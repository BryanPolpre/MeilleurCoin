<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\UserRepository")
 */
class User {
    
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
     * @ORM\ManyToMany(targetEntity="Role", cascade={"persist"})
     */
    private $roles;
        
    /**
     * @ORM\Column(name="date_registered", type="datetime")
     */
    private $dateRegistered;
    
    
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
        $this->password = $password;
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

}
