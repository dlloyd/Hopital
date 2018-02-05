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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

     /**
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Service",inversedBy="rooms")
     */
    private $service;

    /**
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\Equipment",mappedBy="serviceRoom")
    */
    private $equipments;

    


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

    

    /**
     * Add equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return ServiceRoom
     */
    public function addEquipment(\HOEquipmentBundle\Entity\Equipment $equipment)
    {
        $this->equipments[] = $equipment;

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\HOEquipmentBundle\Entity\Equipment $equipment)
    {
        $this->equipments->removeElement($equipment);
    }

    /**
     * Get equipments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipments()
    {
        return $this->equipments;
    }
}
