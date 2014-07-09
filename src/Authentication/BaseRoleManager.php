<?php
namespace EVFramework\Authentication;

use Trolamine\Core\Authentication\Role\RoleManager;
use Trolamine\Core\Authentication\UserDetails;
use Evaneos\Modules\User\User;

class BaseRoleManager implements RoleManager
{
    /*
     * Exteriors
    */
    public $roles = array (
        'ROLE_VISITOR'          => 0,
        'ROLE_LOGGED'           => 1,
        'ROLE_ADMIN'            => 2,
        'ROLE_DEVELOPPER'       => 4,
    );

    /**
     * (non-PHPdoc)
     * @see \Trolamine\Core\Authentication\Role\RoleManager::getRoles()
     */
    public function getRoles(UserDetails $userDetails) {
        /* @var $user User */
        $user = $userDetails->getUser();
        $acl = $user->getAcl() ;

        return $this->getRolesFromBitwise((int)$acl);
    }

    /**
     * Returns the list of roles according to the bitwise passed in parameter
     *
     * @param int $bitwise
     *
     * @return array<string>
     */
    private function getRolesFromBitwise($bitwise) {
        $roles = array();

        foreach ($this->roles as $roleName=>$roleValue) {
            if((bool) ($roleValue & $bitwise)) {
                $roles[] = $roleName;
            }
        }

        return $roles;
    }
}