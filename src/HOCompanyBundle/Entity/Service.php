<?php

namespace HOCompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="HOCompanyBundle\Repository\ServiceRepository")
 */
class Service
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
    * @ORM\OneToMany(targetEntity="HOCompanyBundle\Entity\ServiceRoom",mappedBy="service")
    */
    private $rooms;

    /**
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\Equipment",mappedBy="service")
    */
    private $equipments;

    /**
    * @ORM\OneToMany(targetEntity="HOInterventionBundle\Entity\AlertService",mappedBy="service")
    */
    private $alerts;



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
        $this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Service
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
     * Add room
     *
     * @param \HOCompanyBundle\Entity\ServiceRoom $room
     *
     * @return Service
     */
    public function addRoom(\HOCompanyBundle\Entity\ServiceRoom $room)
    {
        $this->rooms[] = $room;

        return $this;
    }

    /**
     * Remove room
     *
     * @param \HOCompanyBundle\Entity\ServiceRoom $room
     */
    public function removeRoom(\HOCompanyBundle\Entity\ServiceRoom $room)
    {
        $this->rooms->removeElement($room);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Add equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return Service
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

    /**
     * Add alert
     *
     * @param \HOInterventionBundle\Entity\AlertService $alert
     *
     * @return Service
     */
    public function addAlert(\HOInterventionBundle\Entity\AlertService $alert)
    {
        $this->alerts[] = $alert;

        return $this;
    }

    /**
     * Remove alert
     *
     * @param \HOInterventionBundle\Entity\AlertService $alert
     */
    public function removeAlert(\HOInterventionBundle\Entity\AlertService $alert)
    {
        $this->alerts->removeElement($alert);
    }

    /**
     * Get alerts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlerts()
    {
        return $this->alerts;
    }
}
