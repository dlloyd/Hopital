<?php

namespace HOInterventionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Intervention
 *
 * @ORM\Table(name="intervention")
 * @ORM\Entity(repositoryClass="HOInterventionBundle\Repository\InterventionRepository")
 */
class Intervention
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
     * @ORM\ManyToOne(targetEntity="HOInterventionBundle\Entity\AlertService",fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)  
     */
    private $alert;

    /** 
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\ServiceRoom",fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)  
     */
    private $serviceRoom;

    /** 
     * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Equipment",inversedBy="interventions",fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)  
     */
    private $equipment;  

    /**
    * @ORM\OneToMany(targetEntity="HOInterventionBundle\Entity\InterventionEquipment", mappedBy="intervention", cascade={"persist"})
    */
    private $interventionTools;

    /**
    * @ORM\OneToMany(targetEntity="HOSparePartBundle\Entity\SparePart", mappedBy="intervention", cascade={"persist"})
    */
    private $spareParts;

    /** 
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Repairer",inversedBy="interventions",fetch="EAGER")  
     */
    private $repairer;


    /**
     * @ORM\Column(name="date_begin", type="datetime", nullable=false)     
     */
    private $dateBegin;


    /**
     * @ORM\Column(name="date_end", type="datetime", nullable=true)     
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text",nullable=true)
     */
    private $comment;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_closed", type="boolean")
     */
    private $isClosed; // le réparateur à réussi 


    /** 
     * @ORM\ManyToOne(targetEntity="HOInterventionBundle\Entity\InterventionCategory",fetch="EAGER")
     */
    private $category;  // préventive ou currative


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
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     *
     * @return Intervention
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime
     */
    public function getDateBegin()
    {
        if($this->dateBegin!=null)
            return $this->dateBegin->format('d/m/Y');
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return Intervention
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        if($this->dateEnd!=null)
            return $this->dateEnd->format('d/m/Y');
        return $this->dateEnd;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Intervention
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
     * Set alert
     *
     * @param \HOInterventionBundle\Entity\AlertService $alert
     *
     * @return Intervention
     */
    public function setAlert(\HOInterventionBundle\Entity\AlertService $alert = null)
    {
        $this->alert = $alert;

        return $this;
    }

    /**
     * Get alert
     *
     * @return \HOInterventionBundle\Entity\AlertService
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * Set equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return Intervention
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
     * Set repairer
     *
     * @param \HOCompanyBundle\Entity\Repairer $repairer
     *
     * @return Intervention
     */
    public function setRepairer(\HOCompanyBundle\Entity\Repairer $repairer = null)
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
     * Set isClosed
     *
     * @param boolean $isClosed
     *
     * @return Intervention
     */
    public function setIsClosed($isClosed)
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    /**
     * Get isClosed
     *
     * @return boolean
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * Set category
     *
     * @param \HOInterventionBundle\Entity\InterventionCategory $category
     *
     * @return Intervention
     */
    public function setCategory(\HOInterventionBundle\Entity\InterventionCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \HOInterventionBundle\Entity\InterventionCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set serviceRoom
     *
     * @param \HOCompanyBundle\Entity\ServiceRoom $serviceRoom
     *
     * @return Intervention
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
     * Constructor
     */
    public function __construct()
    {
        $this->interventionTools = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add interventionTool
     *
     * @param \HOInterventionBundle\Entity\InterventionEquipment $interventionTool
     *
     * @return Intervention
     */
    public function addInterventionTool(\HOInterventionBundle\Entity\InterventionEquipment $interventionTool)
    {
        $this->interventionTools[] = $interventionTool;

        return $this;
    }

    /**
     * Remove interventionTool
     *
     * @param \HOInterventionBundle\Entity\InterventionEquipment $interventionTool
     */
    public function removeInterventionTool(\HOInterventionBundle\Entity\InterventionEquipment $interventionTool)
    {
        $this->interventionTools->removeElement($interventionTool);
    }

    /**
     * Get interventionTools
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterventionTools()
    {
        return $this->interventionTools;
    }

    /**
     * Add sparePart
     *
     * @param \HOSparePartBundle\Entity\SparePart $sparePart
     *
     * @return Intervention
     */
    public function addSparePart(\HOSparePartBundle\Entity\SparePart $sparePart)
    {
        $this->spareParts[] = $sparePart;

        return $this;
    }

    /**
     * Remove sparePart
     *
     * @param \HOSparePartBundle\Entity\SparePart $sparePart
     */
    public function removeSparePart(\HOSparePartBundle\Entity\SparePart $sparePart)
    {
        $this->spareParts->removeElement($sparePart);
    }

    /**
     * Get spareParts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpareParts()
    {
        return $this->spareParts;
    }
}
