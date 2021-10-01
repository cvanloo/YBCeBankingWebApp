<?php
namespace Modules\Interfaces;

use Modules\Entity;

public interface IUserRepository {
    /**
     * @return User
     */
    public function getUserById(Long $id) : User

    /**
     * @return User[]
     */
    public function getUsers() : array

    /**
     * 
     */
    public function createUser(User $user) : User
}

?>