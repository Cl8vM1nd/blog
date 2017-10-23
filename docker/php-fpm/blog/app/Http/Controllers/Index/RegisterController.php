<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Index;

use App\Entities\Admin;
use App\Entities\UserType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function postIndex(Request $request)
    {

        $user = new User($request->input('email'), $request->input('password'), $request->input('name'), UserType::ADMIN);
        $admin = new Admin($request->input('email'), $request->input('password'), $request->input('name'));

        \EntityManager::persist($admin);
        \EntityManager::persist($user);
        \EntityManager::flush();

        \Auth::guard('admin')->login($admin);
        return "ok";
    }
}