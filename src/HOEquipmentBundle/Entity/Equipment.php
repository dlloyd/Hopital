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
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    
    
    /**
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\EquipmentCategory",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $category;

    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Stock",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $stock;

    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Service",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $service;



    /**
     * @var boolean
     *
     * @ORM\Column(name="is_broken", type="boolean")
     */
    private $isBroken;

    /**
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\EquipmentReparation", mappedBy="equipment", cascade={"persist"})
    */
    private $reparations;

   
   /**
   *@ORM\OneToMany(targetEntity="HOSparePartBundle\Entity\SparePart", mappedBy="equipment", cascade={"persist"}) 
   */
   private $spareParts;


    /**
     * @ORM\Column(name="manufacture_date", type="datetime", nullable=true)     
     */
    private $manufactureDate; // date de fabrication


    /**
     * @ORM\Column(name="use_date", type="datetime", nullable=true)     
     */
    private $useDate;  // date d'utilisation


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
     * Constructor
     */
    public function __construct()
    {
        $this->reparations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add reparation
     *
     * @param \HOEquipmentBundle\Entity\EquipmentReparation $reparation
     *
     * @return Equipment
     */
    public function addReparation(\HOEquipmentBundle\Entity\EquipmentReparation $reparation)
    {
        $this->reparations[] = $reparation;

        return $this;
    }

    /**
     * Remove reparation
     *
     * @param \HOEquipmentBundle\Entity\EquipmentReparation $reparation
     */
    public function removeReparation(\HOEquipmentBundle\Entity\EquipmentReparation $reparation)
    {
        $this->reparations->removeElement($reparation);
    }

    /**
     * Get reparations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReparations()
    {
        return $this->reparations;
    }

    /**
     * Set stock
     *
     * @param \HOCompanyBundle\Entity\Stock $stock
     *
     * @return Equipment
     */
    public function setStock(\HOCompanyBundle\Entity\Stock $stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \HOCompanyBundle\Entity\Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set service
     *
     * @param \HOCompanyBundle\Entity\Service $service
     *
     * @return Equipment
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
     * Add sparePart
     *
     * @param \HOSparePartBundle\Entity\SparePart $sparePart
     *
     * @return Equipment
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
