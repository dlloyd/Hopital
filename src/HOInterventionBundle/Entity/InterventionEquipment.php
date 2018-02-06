<?php

namespace HOInterventionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InterventionEquipment
 *
 * @ORM\Table(name="intervention_equipment")
 * @ORM\Entity(repositoryClass="HOInterventionBundle\Repository\InterventionEquipmentRepository")
 */
class InterventionEquipment
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
     * @ORM\ManyToOne(targetEntity="HOInterventionBundle\Entity\Intervention",inversedBy="interventionTools")  
     */
    private $intervention;

    /** 
     * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Equipment",fetch="EAGER")  
     */
    private $equipment;  // équipement de la caisse à outil

    /**
     * @ORM\Column(name="date_out", type="datetime", nullable=true)     
     */
    private $dateOut;  //date de sortie

    /**
     * @ORM\Column(name="date_return", type="datetime", nullable=true)     
     */
    private $dateReturn;  // date de retour

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_back", type="boolean")
     */
    private $isBack;




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
     * Set dateOut
     *
     * @param \DateTime $dateOut
     *
     * @return InterventionEquipment
     */
    public function setDateOut($dateOut)
    {
        $this->dateOut = $dateOut;

        return $this;
    }

    /**
     * Get dateOut
     *
     * @return \DateTime
     */
    public function getDateOut()
    {
       if($this->dateOut!=null)
            return $this->dateOut->format('d/m/Y');
        return $this->dateOut;
    }

    /**
     * Set dateReturn
     *
     * @param \DateTime $dateReturn
     *
     * @return InterventionEquipment
     */
    public function setDateReturn($dateReturn)
    {
        $this->dateReturn = $dateReturn;

        return $this;
    }

    /**
     * Get dateReturn
     *
     * @return \DateTime
     */
    public function getDateReturn()
    {
       if($this->dateReturn!=null)
            return $this->dateReturn->format('d/m/Y');
        return $this->dateReturn;
    }

    /**
     * Set intervention
     *
     * @param \HOInterventionBundle\Entity\Intervention $intervention
     *
     * @return InterventionEquipment
     */
    public function setIntervention(\HOInterventionBundle\Entity\Intervention $intervention = null)
    {
        $this->intervention = $intervention;

        return $this;
    }

    /**
     * Get intervention
     *
     * @return \HOInterventionBundle\Entity\Intervention
     */
    public function getIntervention()
    {
        return $this->intervention;
    }

    /**
     * Set equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return InterventionEquipment
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
     * Set isBack
     *
     * @param boolean $isBack
     *
     * @return InterventionEquipment
     */
    public function setIsBack($isBack)
    {
        $this->isBack = $isBack;

        return $this;
    }

    /**
     * Get isBack
     *
     * @return boolean
     */
    public function getIsBack()
    {
        return $this->isBack;
    }
}
