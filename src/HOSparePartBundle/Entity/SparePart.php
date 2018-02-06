<?php

namespace HOSparePartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SparePart
 *
 * @ORM\Table(name="spare_part")
 * @ORM\Entity(repositoryClass="HOSparePartBundle\Repository\SparePartRepository")
 */
class SparePart
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
     * @ORM\Column(name="serial_number", type="string")
     */
    private $serialNumber;

    /**
    * @ORM\ManyToOne(targetEntity="HOSparePartBundle\Entity\SparePartType",inversedBy="spareParts",fetch="EAGER")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $type;
  

    /**
     * @var string
     *
     * @ORM\Column(name="designation_compl", type="string",nullable=true)
     */
    private $complDesignation; //désignation complémentaire

    /**
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\EquipmentBrand",fetch="EAGER")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $brand;

    /**
     * @ORM\Column(name="manufacture_date", type="datetime", nullable=true)     
     */
    private $manufactureDate; // date de fabrication

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_used", type="boolean")
     */
    private $isUsed;


    /**
    * @ORM\ManyToOne(targetEntity="HOInterventionBundle\Entity\Intervention",inversedBy="spareParts")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $intervention;



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
     * Set isUsed
     *
     * @param boolean $isUsed
     *
     * @return SparePart
     */
    public function setIsUsed($isUsed)
    {
        $this->isUsed = $isUsed;

        return $this;
    }

    /**
     * Get isUsed
     *
     * @return boolean
     */
    public function getIsUsed()
    {
        return $this->isUsed;
    }

    /**
     * Set type
     *
     * @param \HOSparePartBundle\Entity\SparePartType $type
     *
     * @return SparePart
     */
    public function setType(\HOSparePartBundle\Entity\SparePartType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \HOSparePartBundle\Entity\SparePartType
     */
    public function getType()
    {
        return $this->type;
    }

    

    /**
     * Set serialNumber
     *
     * @param string $serialNumber
     *
     * @return SparePart
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Get serialNumber
     *
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Set complDesignation
     *
     * @param string $complDesignation
     *
     * @return SparePart
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
     * Set manufactureDate
     *
     * @param \DateTime $manufactureDate
     *
     * @return SparePart
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
        return $this->manufactureDate;
    }

    /**
     * Set brand
     *
     * @param \HOEquipmentBundle\Entity\EquipmentBrand $brand
     *
     * @return SparePart
     */
    public function setBrand(\HOEquipmentBundle\Entity\EquipmentBrand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \HOEquipmentBundle\Entity\EquipmentBrand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set intervention
     *
     * @param \HOInterventionBundle\Entity\Intervention $intervention
     *
     * @return SparePart
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
}
