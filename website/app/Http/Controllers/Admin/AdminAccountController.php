<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Http\Controllers\Admin;

use App\Entities\Admin;
use App\Entities\User;
use Illuminate\Http\Request;

class AdminAccountController extends AdminBaseController
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
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|exists:App\Entities\Admin,email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->returnErrors($request);
        }

        /** @var User $account */
        $account = \EntityManager::getRepository(Admin::class)->findOneBy(['email' => $request->input('email')]);

        if (!\Hash::check($request->input('password'),$account->getPassword())) {
            return $this->returnErrors($request);
        }

        if (\Auth::guard('admin')->attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ])) {

            return redirect()->route('admin::index');
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function returnErrors(Request $request)
    {
        $this->unauthorizedLogin($request);
        return redirect('admin/login')
            ->withErrors(['errors' => 'Login or Password invalid.'])
            ->withInput();
    }

    /**
     * @param Request $request
     */
    protected function unauthorizedLogin(Request $request)
    {
        $message = 'Unauthorized access!Email: ' . $request->input('email')
            . ', password: ' . $request->input('password') . "\n"
            . 'User-Agent: ' . $request->header('User-Agent')
            . "\nIP: " . $request->ip();
        \Log::debug($message);
        mail('clevmind@yandex.ru', 'Unauthorized Access', $message);
    }
}