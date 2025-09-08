<?php

namespace App\Console\Commands;

use App\Interfaces\Services\UserServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Database\UniqueConstraintViolationException;

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
        $username = $this->ask("username : ");
        $password = $this->ask("password : ");
        $email = $this->ask("email : ");
        
        try {
            $this->userService->createUser([
                "username" => $username ,
                "password" => $password ,
                "email" => $email ,
                "role" => 2 ,
                "is_verified" => true
            ]);
        } 
        catch (UniqueConstraintViolationException $e) 
        {
            $this->error("username or email is used before! ");
        }
    }
}
