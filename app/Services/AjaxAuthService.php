<?php
# CrEaTeD bY FaI8T IlYa      
# 2017  

namespace App\Services;

class AjaxAuthService
{
    const GUID = '8"XAb9%7tXG}<<=(Dl#m#gj$+ZGD^v';
    const SALT = 'sYn6?3WvU>aW2a`K{p+?\Ln8E9g<RL';

    const USER_ID = 'user_id';
    const USER_AUTH_HASH = 'user_auth_hash';
    const USER_HASH_LENGTH = 45;

    protected $authToken;

    protected $authHash;

    /**
     * AjaxAuthService constructor.
     */
    public function __construct()
    {
        if (!session()->has(AjaxAuthService::USER_ID)) {
            session([AjaxAuthService::USER_ID => $this->getRandUserId()]);
        }

        $this->generateHash();
    }

    /**
     * @return int
     */
    protected function getRandUserId(): int
    {
        mt_srand($this->make_seed());
        $this->userId = mt_rand(1, 7000000);

        return $this->userId;
    }

    /**
     * @return mixed
     */
    protected function make_seed()
    {
        list($usec, $sec) = explode(' ', microtime());

        return $sec + $usec * 1000000;
    }

    /**
     * @return mixed
     */
    protected function getUserId()
    {
        return session(AjaxAuthService::USER_ID);
    }

    /**
     * @return mixed
     */
    protected function getAuthHash()
    {
        \Log::debug( ' AuthHash:' . session(AjaxAuthService::USER_AUTH_HASH));
        return session(AjaxAuthService::USER_AUTH_HASH);
    }

    protected function saveAuthHash()
    {
        session([AjaxAuthService::USER_AUTH_HASH => $this->authHash]);
        return $this->getAuthHash();
    }

    /**
     * @param bool $update
     * @return mixed|string
     */
    public function generateHash(bool $update = false)
    {
        $this->generateNewHash();
        if (session()->has(AjaxAuthService::USER_AUTH_HASH) && $update) {
            return $this->saveAuthHash();
        } else if(!session()->has(AjaxAuthService::USER_AUTH_HASH)) {
            return $this->saveAuthHash();
        } else {
            return $this->getAuthHash();
        }
    }

    protected function generateNewHash()
    {
        $this->authToken = encrypt(AjaxAuthService::GUID . time());
        $this->authHash = substr(encrypt($this->getUserId() . $this->authToken . AjaxAuthService::SALT), 0, AjaxAuthService::USER_HASH_LENGTH);
        \Log::debug('userId:' . $this->getUserId() . ' - authToken:' . $this->authToken . "\n");
    }
}