<?php

namespace HOCompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlertService
 *
 * @ORM\Table(name="alert_service")
 * @ORM\Entity(repositoryClass="HOCompanyBundle\Repository\AlertServiceRepository")
 */
class AlertService
{
    
     /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Service", inversedBy="alerts") 
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", nullable=false) 
     */
    private $service;

     /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Equipment") 
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id", nullable=false) 
     */
    private $equipment;

    /**
     * @ORM\Column(name="date", type="mydatetime", nullable=false)     
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $date;


   
    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\AlertState")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $alertState;


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
     * @param mydatetime $date
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
     * @return mydatetime
     */
    public function getDate()
    {
        if($this->date!= null )
            return $this->date->format('d/m/Y');
        return $this->date;
    }

    /**
     * Set service
     *
     * @param \HOCompanyBundle\Entity\Service $service
     *
     * @return AlertService
     */
    public function setService(\HOCompanyBundle\Entity\Service $service)
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
     * Set equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return AlertService
     */
    public function setEquipment(\HOEquipmentBundle\Entity\Equipment $equipment)
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
     * @param \HOCompanyBundle\Entity\AlertState $alertState
     *
     * @return AlertService
     */
    public function setAlertState(\HOCompanyBundle\Entity\AlertState $alertState)
    {
        $this->alertState = $alertState;

        return $this;
    }

    /**
     * Get alertState
     *
     * @return \HOCompanyBundle\Entity\AlertState
     */
    public function getAlertState()
    {
        return $this->alertState;
    }
}
