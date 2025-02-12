<?php

namespace Primitives\Models;

class User
{
    public string $registration_number;
    public string $fullname;
    public string $username;
    public string $password;
    public string $email;
    public string $phone;
    public string $avatar;
    public Role $role;

    public function __construct(string $registration_number,
                                string $fullname,
                                string $username,
                                string $password,
                                string $email,
                                string $phone,
                                string $avatar,
                                Role   $role)
    {
        $this->registration_number = $registration_number;
        $this->fullname = $fullname;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->avatar = $avatar;
        $this->role = $role;
    }

    public function comparePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}