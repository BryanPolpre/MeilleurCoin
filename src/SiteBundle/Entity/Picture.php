<?php
/**
 * Created by PhpStorm.
 * User: bpoupelin2017
 * Date: 18/07/2018
 * Time: 11:07
 */

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ad
 *
 * @ORM\Table(name="Picture")
 * @ORM\Entity()
 */

class Picture
{
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
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="Ad",inversedBy="pictures")
     * @ORM\JoinColumn(name="ad_id",referencedColumnName="id", onDelete="CASCADE")
     */
    private $ad;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * @param mixed $ad
     */
    public function setAd($ad)
    {
        $this->ad = $ad;
    }



}

