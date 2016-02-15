<?php

namespace EVFramework\Authentication;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Log\NullLogger;
use Trolamine\Core\Authentication\Authentication;
use Trolamine\Core\Authentication\AuthenticationManager;
use Trolamine\Core\Authentication\UsernamePasswordAuthenticationToken;
use Trolamine\Core\Exception\BadCredentialsException;
use Trolamine\Core\Exception\InsufficientAuthenticationException;

class ServiceAuthentication
{
    /**
     * @var AuthenticationManager
     */
    private $authenticationManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /** @var Authentication */
    private $auth;

    /**
     * ServiceAuthentication constructor.
     *
     * @param AuthenticationManager $authenticationManager
     */
    public function __construct(AuthenticationManager $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * @param AuthenticationManager $authenticationManager
     *
     * @return $this
     */
    public function setAuthenticationManager(AuthenticationManager $authenticationManager)
    {
        $this->logger = new NullLogger();
        $this->authenticationManager = $authenticationManager;
        return $this;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
        if(true === $this->isLoggedIn()){ //already logged
            return $this->auth;
        }

        session_regenerate_id(true);

        try {
            $this->auth = $this->authenticationManager->authenticate(new UsernamePasswordAuthenticationToken($email, $password));
            $this->logger->notice('User connected', array('email' => $email));
            return $this->auth;
        } catch (InsufficientAuthenticationException $e) {
            $this->logger->notice('Insufficient permission', array('email' => $email));
            return null;
        } catch (BadCredentialsException $e) {
            $this->logger->notice('Bad credential', array('email' => $email));
            return null;
        }
    }

    /**
     * Returns true if user is logged in
     */
    public function isLoggedIn(Authentication $authentication = null)
    {
        if(null === $this->auth && null === $authentication){
            return false;
        }

        if(null === $authentication){
            $authentication = $this->auth;
        }

        dump($authentication->getAuthenticationMode());

        return $authentication->getAuthenticationMode() == Authentication::FULLY_AUTHENTICATED;
    }
}
