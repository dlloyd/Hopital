<?php

namespace HOEquipmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipmentReparation
 *
 * @ORM\Table(name="equipment_reparation")
 * @ORM\Entity(repositoryClass="HOEquipmentBundle\Repository\EquipmentReparationRepository")
 */
class EquipmentReparation
{
    
   /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Repairer", inversedBy="reparations") 
     * @ORM\JoinColumn(name="repairer_id", referencedColumnName="id", nullable=false) 
     */
   private $repairer;

   

   /** 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Equipment", inversedBy="reparations") 
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
     * @var boolean
     *
     * @ORM\Column(name="is_done", type="boolean")
     */
   private $isDone;

   /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text",nullable=true)
     */
   private $comment;

   
   
   /** 
     * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\PanneType") 
     * @ORM\JoinColumn(nullable=true) 
     */
   private $panneType;




    /**
     * Set date
     *
     * @param mydatetime $date
     *
     * @return EquipmentReparation
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
        return $this->date->format('d/m/Y');
    }

    /**
     * Set problem
     *
     * @param string $comment
     *
     * @return EquipmentReparation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    

    /**
     * Set equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return EquipmentReparation
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
     * Constructor
     */
    public function __construct()
    {
        $this->spareParts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set repairer
     *
     * @param \HOCompanyBundle\Entity\Repairer $repairer
     *
     * @return EquipmentReparation
     */
    public function setRepairer(\HOCompanyBundle\Entity\Repairer $repairer)
    {
        $this->repairer = $repairer;

        return $this;
    }

    /**
     * Get repairer
     *
     * @return \HOCompanyBundle\Entity\Repairer
     */
    public function getRepairer()
    {
        return $this->repairer;
    }

   

    /**
     * Set panneType
     *
     * @param \HOEquipmentBundle\Entity\PanneType $panneType
     *
     * @return EquipmentReparation
     */
    public function setPanneType(\HOEquipmentBundle\Entity\PanneType $panneType)
    {
        $this->panneType = $panneType;

        return $this;
    }

    /**
     * Get panneType
     *
     * @return \HOEquipmentBundle\Entity\PanneType
     */
    public function getPanneType()
    {
        return $this->panneType;
    }

    /**
     * Set isDone
     *
     * @param boolean $isDone
     *
     * @return EquipmentReparation
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get isDone
     *
     * @return boolean
     */
    public function getIsDone()
    {
        return $this->isDone;
    }
}
