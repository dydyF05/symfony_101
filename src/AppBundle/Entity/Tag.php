<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollections;

/**
* @ORM\Entity
*/
class Tag
{
    /**
     * Constructor
     */
    public function __construct() {
    }

    /**
    * @var integer
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    /**
    * @var string
    *
    * @ORM\Column(name="name", type="string")
    */
    private $name;

    /**
    * Get the value of Id
    *
    * @return integer
    */
    public function getId()
    {
        return $this->id;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
    * Get the value of Name
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }

}