<?php
namespace EVFramework\Authentication;

use Trolamine\Core\Authentication\Role\RoleManager;
use Trolamine\Core\Authentication\UserDetails;
use Evaneos\Modules\User\User;

class BitwiseRoleManager implements RoleManager
{
    /*
     * Exteriors
    */
    protected $roles = array();

    public function setRoles(array $roles = array())
    {
        $this->roles = $roles;
        return $this;
    }

    public function addRole($name, $bit)
    {
        $this->roles[$name] = $bit;
        return $this;
    }

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