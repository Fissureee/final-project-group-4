<?php

namespace Presentation\Http;

use Presentation\Http\Attributes\Authenticated;
use Presentation\Http\Attributes\Route;
use Presentation\Http\Attributes\WithSession;
use Presentation\Http\Controllers\Controller;
use Presentation\Http\Helpers\Http;

class HttpPresenter
{
    /* @var $controllers Controller[] */
    private array $controllers = [];

    public function register(Controller $controller): void
    {
        $this->controllers[] = $controller;
    }

    public function run(): void
    {
        $request_path = $_SERVER['REQUEST_URI'];
        $request_method = $_SERVER['REQUEST_METHOD'];

        // mock request method since we can't do anything other than POST or GET from the form action
        if (isset($_POST['_method'])) {
            $request_method = $_POST['_method'];
        }

        foreach ($this->controllers as $controller) {
            $reflection = new \ReflectionClass($controller);
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $attributes = $method->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    if ($route->path === $request_path && $route->method === $request_method) {
                        try {
                            if ($request_method === "POST") {
                                $parameters = $method->getParameters();
                                // method doesn't have any parameters so just invoke it
                                if (count($parameters) !== 1) {
                                    $method->invoke($controller);
                                    return;
                                }
                                $dto = $parameters[0]->getType()->getName();
                                // create a new instance of the dto and pass the post data to it
                                $body = new $dto($_POST);
                                $method->invoke($controller, $body);
                                return;
                            }

                            // execute the session attribute if the method has it
                            $session_attributes = $method->getAttributes(WithSession::class);
                            foreach ($session_attributes as $session_attribute) {
                                $session_attribute->newInstance()->startSession();
                            }

                            // execute the authenticated attribute if the method has it to protect the route
                            $authenticated_attributes = $method->getAttributes(Authenticated::class);
                            foreach ($authenticated_attributes as $authenticated_attribute) {
                                // this will redirect to login page if the user is not authenticated
                                $authenticated_attribute->newInstance()->isAuthenticatedWithRole();
                            }

                            $method->invoke($controller);
                        } catch (\ReflectionException $e) {
                            Http::internalServerError($e->getMessage());
                        }
                        return;
                    }
                }
            }
        }

        // try to resolve asset path for any routes that is not registered
        $this->handleStaticFiles($request_path);
    }

    private function handleStaticFiles(string $request_path): void
    {
        $asset_path = dirname(__FILE__) . '/Views/Assets' . $request_path;
        if (file_exists($asset_path)) {
            if (str_ends_with($asset_path, 'css')) {
                header('Content-Type: text/css');
            } else {
                header('Content-Type: ' . mime_content_type($asset_path));
            }
            readfile($asset_path);
            return;
        }

        // by default send not found response if no route is found
        Http::notFound();
    }
}