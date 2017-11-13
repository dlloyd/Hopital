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
    * @ORM\ManyToOne(targetEntity="HOSparePartBundle\Entity\SparePartType",inversedBy="spareParts")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Stock",inversedBy="spareParts")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $stock;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_used", type="boolean")
     */
    private $isUsed;


    /**
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Equipment",inversedBy="spareParts")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $equipment;



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
     * Set name
     *
     * @param string $name
     *
     * @return SparePart
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
     * Set stock
     *
     * @param \HOCompanyBundle\Entity\Stock $stock
     *
     * @return SparePart
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
     * Set equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return SparePart
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
}
