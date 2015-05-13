<?php

namespace EVFramework\Authentication;

use Evaneos\Pro\Framework\Security\EvaneosRoleManager;
use Evaneos\Pro\Framework\Security\EmailUserDetailsService;
use Evaneos\Pro\Framework\Security\EvaneosPasswordEncoder;
use Trolamine\Core\Authentication\Password\PasswordEncoder;
use Trolamine\Core\Authentication\Authentication;
use Trolamine\Core\Authentication\Role\RoleManager;
use Trolamine\Core\Authentication\AuthenticationManager;
use Trolamine\Core\Authentication\UsernamePasswordAuthenticationToken;
use Trolamine\Core\Exception\BadCredentialsException;
use Trolamine\Core\Exception\InsufficientAuthenticationException;

class ServiceAuthentication
{
    private $authenticationManager;

    public function setAuthenticationManager(AuthenticationManager $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
        return $this;
    }

    public function __construct(AuthenticationManager $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * Log an user by its email and password
     *
     * @param   string  $email      the user email
     * @param   string  $password   the user password
     * @return  Authentication      an Authentication
     */
    public function login($email, $password)
    {
        session_regenerate_id(true);
        try {
            return $this->authenticationManager->authenticate(new UsernamePasswordAuthenticationToken($email, $password));
        } catch (InsufficientAuthenticationException $e) {
            return null;
        } catch (BadCredentialsException $e) {
            return null;
        }
    }

    /**
     * Returns true if user is logged in
     */
    public function isLoggedIn(Authentication $authentication = null)
    {
        return ($authentication && $authentication->getAuthenticationMode() == Authentication::FULLY_AUTHENTICATED);
    }
}
