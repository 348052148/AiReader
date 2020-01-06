<?php
namespace App\Lib;

use Closure;

class PasswordBrokerManager extends \Illuminate\Auth\Passwords\PasswordBrokerManager
{

    protected function createTokenRepository(array $config)
    {
        return new CacheTokenRepository();
    }

    /**
     * Send a password reset link to a user.
     *
     * @param array $credentials
     * @return string
     */
    public function sendResetLink(array $credentials)
    {
        // TODO: Implement sendResetLink() method.
    }

    /**
     * Reset the password for the given token.
     *
     * @param array $credentials
     * @param \Closure $callback
     * @return mixed
     */
    public function reset(array $credentials, Closure $callback)
    {
        // TODO: Implement reset() method.
    }

    /**
     * Set a custom password validator.
     *
     * @param \Closure $callback
     * @return void
     */
    public function validator(Closure $callback)
    {
        // TODO: Implement validator() method.
    }

    /**
     * Determine if the passwords match for the request.
     *
     * @param array $credentials
     * @return bool
     */
    public function validateNewPassword(array $credentials)
    {
        // TODO: Implement validateNewPassword() method.
    }
}