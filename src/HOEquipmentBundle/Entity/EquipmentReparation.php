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
     * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Repairer", inversedBy="reparations") 
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
     * @var string
     *
     * @ORM\Column(name="problem", type="text",nullable=true)
     */
   private $problem;




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
        return $this->date;
    }

    /**
     * Set problem
     *
     * @param string $problem
     *
     * @return EquipmentReparation
     */
    public function setProblem($problem)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get problem
     *
     * @return string
     */
    public function getProblem()
    {
        return $this->problem;
    }

    /**
     * Set repairer
     *
     * @param \HOEquipmentBundle\Entity\Repairer $repairer
     *
     * @return EquipmentReparation
     */
    public function setRepairer(\HOEquipmentBundle\Entity\Repairer $repairer)
    {
        $this->repairer = $repairer;

        return $this;
    }

    /**
     * Get repairer
     *
     * @return \HOEquipmentBundle\Entity\Repairer
     */
    public function getRepairer()
    {
        return $this->repairer;
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
}
