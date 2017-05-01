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
    const USER_AUTH_TOKEN = 'user_auth_token';
    const USER_HASH_LENGTH = 45;

    protected $userId;

    protected $authToken;

    protected $authHash;

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
    public function getUserId()
    {
        if (!\Session::has(AjaxAuthService::USER_ID)) {
            \Log::debug('no');
            \Session::set(AjaxAuthService::USER_ID, $this->getRandUserId());
        }
        return \Session::get(AjaxAuthService::USER_ID);
    }

    /**
     * @return mixed
     */
    public function getAuthHash()
    {
        \Log::debug( ' AuthHash:' . \Session::get(AjaxAuthService::USER_AUTH_HASH));
        return \Session::get(AjaxAuthService::USER_AUTH_HASH);
    }

    /**
     * @return mixed
     */
    public function getAuthToken()
    {
        \Log::debug( ' AuthHash:' . \Session::get(AjaxAuthService::USER_AUTH_TOKEN));
        return \Session::get(AjaxAuthService::USER_AUTH_TOKEN);
    }

    /**
     * @param bool $returnCredentials
     * @return mixed|string
     */
    public function generateHash(bool $returnCredentials = false)
    {
        $this->authToken = \Hash::make(AjaxAuthService::GUID . time());
        $this->authHash = \Hash::make($this->getUserId() . $this->authToken . AjaxAuthService::SALT);
        \Session::set(AjaxAuthService::USER_AUTH_TOKEN, $this->authToken);
        \Session::set(AjaxAuthService::USER_AUTH_HASH, $this->authHash);

        if ($returnCredentials) {
            return $this->authToken;
        }
        \Log::debug('userId:' . $this->getUserId() . ' - authToken:' . $this->authToken . "\n" . 'AuthHash - ' . $this->authHash);
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function checkHash(string $hash)
    {
        return \Hash::check($hash . AjaxAuthService::SALT, $this->getAuthHash());
    }
}