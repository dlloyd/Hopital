<?php

namespace HOEquipmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity(repositoryClass="HOEquipmentBundle\Repository\EquipmentRepository")
 */
class Equipment
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
     * @ORM\Column(name="code", type="string")
     */
    private $code;  // numéro de série

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;  // marque

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string",nullable=true)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="designation_compl", type="string",nullable=true)
     */
    private $complDesignation; //désignation complémentaire

    /**
     * @ORM\Column(name="manufacture_date", type="datetime", nullable=true)     
     */
    private $manufactureDate; // date de fabrication


    /**
     * @ORM\Column(name="use_date", type="datetime", nullable=true)     
     */
    private $useDate;  // date d'utilisation

  
    
    /**
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\EquipmentCategory",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $category;

    /**
    * @ORM\ManyToOne(targetEntity="HOStockBundle\Entity\Stock",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $stock;


    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Service",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $service;

    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\ServiceRoom")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $serviceRoom;


    /**
    * @ORM\ManyToOne(targetEntity="HOInterventionBundle\Entity\ToolBox")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $toolBox;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_out", type="boolean")
     */
    private $isOut;   // Uniquement dans le cas de la caisse à outils

    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Supplier")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $supplier;

    /**
    * @ORM\OneToMany(targetEntity="HOInterventionBundle\Entity\Intervention", mappedBy="equipment", cascade={"persist"})
    */
    private $interventions;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_broken", type="boolean")
     */
    private $isBroken;

   


    

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
     * Set code
     *
     * @param string $code
     *
     * @return Equipment
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Equipment
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
     * Set category
     *
     * @param \HOEquipmentBundle\Entity\EquipmentCategory $category
     *
     * @return Equipment
     */
    public function setCategory(\HOEquipmentBundle\Entity\EquipmentCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \HOEquipmentBundle\Entity\EquipmentCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set isBroken
     *
     * @param boolean $isBroken
     *
     * @return Equipment
     */
    public function setIsBroken($isBroken)
    {
        $this->isBroken = $isBroken;

        return $this;
    }

    /**
     * Get isBroken
     *
     * @return boolean
     */
    public function getIsBroken()
    {
        return $this->isBroken;
    }
   

    /**
     * Set stock
     *
     * @param \HOStockBundle\Entity\Stock $stock
     *
     * @return Equipment
     */
    public function setStock(\HOStockBundle\Entity\Stock $stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \HOStockBundle\Entity\Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    
    /**
     * Set manufactureDate
     *
     * @param \DateTime $manufactureDate
     *
     * @return Equipment
     */
    public function setManufactureDate($manufactureDate)
    {
        $this->manufactureDate = $manufactureDate;

        return $this;
    }

    /**
     * Get manufactureDate
     *
     * @return \DateTime
     */
    public function getManufactureDate()
    {
        if($this->manufactureDate!=null)
            return $this->manufactureDate->format('m/d/Y');
        return $this->manufactureDate;
    }

    /**
     * Set useDate
     *
     * @param \DateTime $useDate
     *
     * @return Equipment
     */
    public function setUseDate($useDate)
    {
        $this->useDate = $useDate;

        return $this;
    }

    /**
     * Get useDate
     *
     * @return \DateTime
     */
    public function getUseDate()
    {
        if($this->useDate!=null)
            return $this->useDate->format('d/m/Y');
        return $this->useDate;
    }

    

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Equipment
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set complDesignation
     *
     * @param string $complDesignation
     *
     * @return Equipment
     */
    public function setComplDesignation($complDesignation)
    {
        $this->complDesignation = $complDesignation;

        return $this;
    }

    /**
     * Get complDesignation
     *
     * @return string
     */
    public function getComplDesignation()
    {
        return $this->complDesignation;
    }

    /**
     * Set isOut
     *
     * @param boolean $isOut
     *
     * @return Equipment
     */
    public function setIsOut($isOut)
    {
        $this->isOut = $isOut;

        return $this;
    }

    /**
     * Get isOut
     *
     * @return boolean
     */
    public function getIsOut()
    {
        return $this->isOut;
    }

    /**
     * Set serviceRoom
     *
     * @param \HOCompanyBundle\Entity\ServiceRoom $serviceRoom
     *
     * @return Equipment
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
     * Set toolBox
     *
     * @param \HOInterventionBundle\Entity\ToolBox $toolBox
     *
     * @return Equipment
     */
    public function setToolBox(\HOInterventionBundle\Entity\ToolBox $toolBox = null)
    {
        $this->toolBox = $toolBox;

        return $this;
    }

    /**
     * Get toolBox
     *
     * @return \HOInterventionBundle\Entity\ToolBox
     */
    public function getToolBox()
    {
        return $this->toolBox;
    }

    /**
     * Set supplier
     *
     * @param \HOCompanyBundle\Entity\Supplier $supplier
     *
     * @return Equipment
     */
    public function setSupplier(\HOCompanyBundle\Entity\Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return \HOCompanyBundle\Entity\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set service
     *
     * @param \HOCompanyBundle\Entity\Service $service
     *
     * @return Equipment
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
     * Constructor
     */
    public function __construct()
    {
        $this->interventions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add intervention
     *
     * @param \HOInterventionBundle\Entity\Intervention $intervention
     *
     * @return Equipment
     */
    public function addIntervention(\HOInterventionBundle\Entity\Intervention $intervention)
    {
        $this->interventions[] = $intervention;

        return $this;
    }

    /**
     * Remove intervention
     *
     * @param \HOInterventionBundle\Entity\Intervention $intervention
     */
    public function removeIntervention(\HOInterventionBundle\Entity\Intervention $intervention)
    {
        $this->interventions->removeElement($intervention);
    }

    /**
     * Get interventions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterventions()
    {
        return $this->interventions;
    }
}
