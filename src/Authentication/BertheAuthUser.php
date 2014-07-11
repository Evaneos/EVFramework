<?php

namespace EVFramework\Authentication;

class BertheAuthUser extends \Berthe\AbstractVO {
    const VERSION = 1;

    protected $firstname = "";
    protected $lastname = "";
    protected $email = "";
    protected $password = "";
    protected $salt = "";
    protected $acl = 0;

    /**
     * Get user lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get user firstname
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Gets the login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->email;
    }

    /**
     * Gets the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets the ACL bitwise
     *
     * @return number
     */
    public function getAcl()
    {
        return $this->acl;
    }

    public function getSalt()
    {
        return $this->salt;
    }
}