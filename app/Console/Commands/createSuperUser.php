<?php

namespace App\Console\Commands;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Console\Command;

class createSuperUser extends Command
{
    public function __construct(private UserServiceInterface $userService)
    {
        parent::__construct();
    }
    
    protected $signature = 'app:create-super-user';

    
    protected $description = 'Command description';

    public function handle()
    {
        $this->userService->createUser([
            "username" => env("SUPERUSER_NAME") ,
            "password" => env("SUPERUSER_password") ,
            "email" => env("SUPERUSER_EMAIL") ,
            "role" => 2 ,
            "is_verified" => true
        ]);
    }
}
