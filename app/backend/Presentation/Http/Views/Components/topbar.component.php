<div class="topbar">
    <form action="/" method="get" class="searchbar">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M26.1333 28L17.7333 19.6C17.0667 20.1333 16.3 20.5556 15.4333 20.8667C14.5667 21.1778 13.6444 21.3333 12.6667 21.3333C10.2444 21.3333 8.19467 20.4942 6.51733 18.816C4.84 17.1378 4.00089 15.088 4 12.6667C4 10.2444 4.83911 8.19467 6.51733 6.51733C8.19556 4.84 10.2453 4.00089 12.6667 4C15.0889 4 17.1387 4.83911 18.816 6.51733C20.4933 8.19556 21.3324 10.2453 21.3333 12.6667C21.3333 13.6444 21.1778 14.5667 20.8667 15.4333C20.5556 16.3 20.1333 17.0667 19.6 17.7333L28 26.1333L26.1333 28ZM12.6667 18.6667C14.3333 18.6667 15.7502 18.0831 16.9173 16.916C18.0844 15.7489 18.6676 14.3324 18.6667 12.6667C18.6667 11 18.0831 9.58311 16.916 8.416C15.7489 7.24889 14.3324 6.66578 12.6667 6.66667C11 6.66667 9.58311 7.25022 8.416 8.41733C7.24889 9.58444 6.66578 11.0009 6.66667 12.6667C6.66667 14.3333 7.25022 15.7502 8.41733 16.9173C9.58444 18.0844 11.0009 18.6676 12.6667 18.6667Z"
                  fill="currentColor"/>
        </svg>
        <input type="text" name="room_name" class="searchbar-input" placeholder="Search Rooms...">
    </form>
    <div class="dropdown">
        <img class="topbar-profile dropdown-toggle" src="/<?= $data['user']['avatar'] ?>" alt="profile"
             id="dropdownMenuButton1" data-bs-toggle="dropdown"
             aria-expanded="false">
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Logout</a></li>
        </ul>
    </div>
</div>