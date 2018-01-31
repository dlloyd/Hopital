<?php

namespace HOCompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceRoom
 *
 * @ORM\Table(name="service_room")
 * @ORM\Entity(repositoryClass="HOCompanyBundle\Repository\ServiceRoomRepository")
 */
class ServiceRoom
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
     *
     * @ORM\Column(name="name", type="string",unique=true)
     */
    private $name;

     /**
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Service",inversedBy="rooms")
     */
    private $service;

    


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ServiceRoom
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set service
     *
     * @param \HOCompanyBundle\Entity\Service $service
     *
     * @return ServiceRoom
     */
    public function setService(\HOCompanyBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \HOCompanyBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    
}
