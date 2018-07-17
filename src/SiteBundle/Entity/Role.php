<?php

namespace SiteBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\RoleRepository")
 */
class Role {
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * @ORM\Column(type="string",length=255)
     */
    private $libelle;
    
}
