<?php
namespace EVFramework\Authentication;

use Trolamine\Core\Authentication\Password\PasswordEncoder;

class BasePasswordEncoder implements PasswordEncoder
{

    /**
     * @param  string $credentials
     * @return string $salt
     */
    public function encodePassword($credentials, $salt = null)
    {
        return sha1("--" . $salt . "--" . $credentials . "--");
    }
}
