<?php
namespace EVFramework\Authentication;

use Trolamine\Core\Exception\InsufficientAuthenticationException;
use Trolamine\Core\Authentication\UserDetailsService;
use Trolamine\Core\Authentication\User as TrolamineUser;

class BaseUserDetailsService extends \Berthe\BaseManager implements UserDetailsService
{
    /**
     * (non-PHPdoc)
     * @see \Trolamine\Core\Authentication\UserDetailsService::loadUserByUsername()
     */
    public function loadUserByUsername($email)
    {

        $fetcher = new BertheAuthUserFetcher(1, 1);
        $fetch   = $fetcher->filterByEmail($email);
        $result  = $this->getByFetcher($fetch)->getResultSet();
        $user    = reset($result);

        if (!$user) {
            throw new InsufficientAuthenticationException();
        }

        return new TrolamineUser($user, $user->getLogin(), $user->getPassword(), $user->getSalt());
    }
}
