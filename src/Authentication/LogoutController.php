<?php

namespace EVFramework\Authentication;

use Pyrite\Layer\Executor\Executable;
use Pyrite\Response\ResponseBag;
use Symfony\Component\HttpFoundation\Request;
use Trolamine\Core\SecurityContext;
use Trolamine\Core\Authentication\AnonymousAuthenticationToken;
use Trolamine\Layer\AuthenticationLayer;

class LogoutController implements Executable
{

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    public function execute(Request $request, ResponseBag $bag)
    {
        $authentication = new AnonymousAuthenticationToken();

        $this->securityContext->setAuthentication($authentication);
        $bag->set(AuthenticationLayer::VAR_NAME, $authentication);

        return "success";
    }
}
