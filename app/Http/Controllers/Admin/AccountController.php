<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Admin;

use App\Entities\Admin;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends AdminBaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        return view('admin.login');
    }

    protected function setRepos()
    {
        // TODO: Implement setRepos() method.
    }

    /**
     * @param Request $request
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:App\Entities\Admin,email',
            'password' => 'required|string'
        ]);

        /** @var User $account */
        $account = \EntityManager::getRepository(Admin::class)->findOneBy(['email' => $request->input('email')]);

        if (!password_verify($request->input('password'), $account->getPassword())) {
            return redirect('admin/login')
                ->withErrors(['errors' => 'Login or Password invalid.'])
                ->withInput();
        }

        if (\Auth::guard('admin')->attempt([
                'email' => $request->input('email'), 'password' => $request->input('password')
            ])) {

            return redirect()->route('admin::index');
        }

    }
}