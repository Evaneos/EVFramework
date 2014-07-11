<?php

namespace EVFramework\Authentication;

use Pyrite\Layer\Executor\Executable;
use Pyrite\Response\ResponseBag;
use Symfony\Component\HttpFoundation\Request;
use Trolamine\Layer\AuthenticationLayer;
use Trolamine\Core\SecurityContext;

class LoginPostController implements Executable
{

    private $serviceAuthentication;

    private $securityContext;

    private $emailFieldName = '';

    private $passwordFieldName = '';

    public function __construct(ServiceAuthentication $serviceAuthentication, SecurityContext $securityContext)
    {
        $this->serviceAuthentication  = $serviceAuthentication;
        $this->securityContext = $securityContext;
    }

    public function setEmailFieldName($value)
    {
        $this->emailFieldName = $value;
        return $this;
    }

    public function setPasswordFieldName($value)
    {
        $this->passwordFieldName = $value;
        return $this;
    }

    public function execute(Request $request, ResponseBag $bag)
    {
        $email          = $request->get($this->emailFieldName);
        $password       = $request->get($this->passwordFieldName);

        $authenticationToken = $this->serviceAuthentication->login($email, $password);

        if ($this->serviceAuthentication->isLoggedIn($authenticationToken)) {
            $bag->set(AuthenticationLayer::VAR_NAME, $authenticationToken);
            $this->securityContext->setAuthentication($authenticationToken);
            return "success";
        }

        $bag->set('error', 'notfound');

        return "failure";
    }
}
