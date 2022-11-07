<?php

namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($email, $password)
    {
        if(Auth::attempt(['email' => $email, 'password' => $password])) {
            $user =  $this->userRepository->where('email', $email);
           return $user->createToken('api-token')->plainTextToken;
        }
    }

}
