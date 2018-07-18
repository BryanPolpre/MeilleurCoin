<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\UserRepository")
 * @UniqueEntity("username", message = "Ce nom d'utilisateur existe déjà")
 * @UniqueEntity("email", message = "Cet email est déjà utilisé")
 */
class User implements UserInterface {
    
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",length=50)
     */
    private $username;    
    
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $email;
        
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $password;
        
    /**
     * @ORM\Column(type="array")
     */
    private $roles;
        
    /**
     * @ORM\Column(name="date_registered", type="datetime")
     */
    private $dateRegistered;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getDateRegistered() {
        return $this->dateRegistered;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password) {
        $this->password = sha1($password);
        return $this;
    }

    public function setRoles($roles) {
        $this->roles = $roles;
        return $this;
    }

    public function setDateRegistered($dateRegistered) {
        $this->dateRegistered = $dateRegistered;
        return $this;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return null;
    }
}
