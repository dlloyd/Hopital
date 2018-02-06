<?php

namespace HOInterventionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlertService
 *
 * @ORM\Table(name="alert_service")
 * @ORM\Entity(repositoryClass="HOInterventionBundle\Repository\AlertServiceRepository")
 */
class AlertService
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
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Service", inversedBy="alerts",fetch="EAGER") 
     */
    private $service;

    /** 
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\ServiceRoom")
     * @ORM\JoinColumn(nullable=true) 
     */
    private $serviceRoom;

    /** 
     * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Equipment",fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)  
     */
    private $equipment;

    /**
     * @ORM\Column(name="date", type="datetime", nullable=false)     
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="designation_alert", type="string")
     */
    private $designation;


   
    /**
    * @ORM\ManyToOne(targetEntity="HOInterventionBundle\Entity\AlertState",fetch="EAGER")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $alertState;


    /**
    * @ORM\ManyToOne(targetEntity="HOInterventionBundle\Entity\AlertCategory",fetch="EAGER")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $AlertCategory;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_awarded", type="boolean")
     */
    private $isAwarded;  // si l'alerte est attribuée (intervention en cours )


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AlertService
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        if($this->date!=null)
            return $this->date->format('d/m/Y');
        return $this->date;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return AlertService
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set service
     *
     * @param \HOCompanyBundle\Entity\Service $service
     *
     * @return AlertService
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
     * Set serviceRoom
     *
     * @param \HOCompanyBundle\Entity\ServiceRoom $serviceRoom
     *
     * @return AlertService
     */
    public function setServiceRoom(\HOCompanyBundle\Entity\ServiceRoom $serviceRoom = null)
    {
        $this->serviceRoom = $serviceRoom;

        return $this;
    }

    /**
     * Get serviceRoom
     *
     * @return \HOCompanyBundle\Entity\ServiceRoom
     */
    public function getServiceRoom()
    {
        return $this->serviceRoom;
    }

    /**
     * Set equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return AlertService
     */
    public function setEquipment(\HOEquipmentBundle\Entity\Equipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \HOEquipmentBundle\Entity\Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set alertState
     *
     * @param \HOInterventionBundle\Entity\AlertState $alertState
     *
     * @return AlertService
     */
    public function setAlertState(\HOInterventionBundle\Entity\AlertState $alertState)
    {
        $this->alertState = $alertState;

        return $this;
    }

    /**
     * Get alertState
     *
     * @return \HOInterventionBundle\Entity\AlertState
     */
    public function getAlertState()
    {
        return $this->alertState;
    }

    /**
     * Set alertCategory
     *
     * @param \HOInterventionBundle\Entity\AlertCategory $alertCategory
     *
     * @return AlertService
     */
    public function setAlertCategory(\HOInterventionBundle\Entity\AlertCategory $alertCategory)
    {
        $this->AlertCategory = $alertCategory;

        return $this;
    }

    /**
     * Get alertCategory
     *
     * @return \HOInterventionBundle\Entity\AlertCategory
     */
    public function getAlertCategory()
    {
        return $this->AlertCategory;
    }

    /**
     * Set isAwarded
     *
     * @param boolean $isAwarded
     *
     * @return AlertService
     */
    public function setIsAwarded($isAwarded)
    {
        $this->isAwarded = $isAwarded;

        return $this;
    }

    /**
     * Get isAwarded
     *
     * @return boolean
     */
    public function getIsAwarded()
    {
        return $this->isAwarded;
    }
}
