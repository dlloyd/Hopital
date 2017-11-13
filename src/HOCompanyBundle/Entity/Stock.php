<?php

namespace HOCompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="HOCompanyBundle\Repository\StockRepository")
 */
class Stock
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
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\Equipment",mappedBy="stock", cascade={"persist"})
    */
    private $equipments;


    /**
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\Equipment",mappedBy="stock", cascade={"persist"})
    */
    private $spareParts;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Zone")
     */
    private $zone;




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
     * Constructor
     */
    public function __construct()
    {
        $this->equipments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->spareParts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return Stock
     */
    public function addEquipment(\HOEquipmentBundle\Entity\Equipment $equipment)
    {
        $this->equipments[] = $equipment;

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\HOEquipmentBundle\Entity\Equipment $equipment)
    {
        $this->equipments->removeElement($equipment);
    }

    /**
     * Get equipments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipments()
    {
        return $this->equipments;
    }

    /**
     * Add sparePart
     *
     * @param \HOEquipmentBundle\Entity\Equipment $sparePart
     *
     * @return Stock
     */
    public function addSparePart(\HOEquipmentBundle\Entity\Equipment $sparePart)
    {
        $this->spareParts[] = $sparePart;

        return $this;
    }

    /**
     * Remove sparePart
     *
     * @param \HOEquipmentBundle\Entity\Equipment $sparePart
     */
    public function removeSparePart(\HOEquipmentBundle\Entity\Equipment $sparePart)
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

    /**
     * Set zone
     *
     * @param \HOCompanyBundle\Entity\Zone $zone
     *
     * @return Stock
     */
    public function setZone(\HOCompanyBundle\Entity\Zone $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \HOCompanyBundle\Entity\Zone
     */
    public function getZone()
    {
        return $this->zone;
    }
}
