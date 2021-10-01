<?php
namespace Modules\Interfaces;

use Modules\Repositories\Entity;

/**
 * Repository pattern interface for the User entity.
 */
public interface IUserRepository {

    /**
     * Get a user based on its id.
     * 
     * @param Long $id Id of the user.
     * @return User The found user or NULL.
     */
    public function getUserById(Long $id) : User;

    /**
     * Get all users.
     * 
     * @return User[] An array of users.
     */
    public function getUsers() : array;

    /**
     * Create a new user.
     * 
     * @param User $user The user to create.
     * @return User The created user or NULL.
     */
    public function createUser(User $user) : User;

    /**
     * Modify a user.
     *
     * @param User $user The modified user.
     * @return User The modified user or NULL.
     */
    public function updateUser(User $user) : User;

    /**
     * Delete a user.
     * 
     * @param Long $id The id of the user to delete.
     * @return bool True on success.
     */
    public function deleteUser(Long $id) : bool;
}

?>