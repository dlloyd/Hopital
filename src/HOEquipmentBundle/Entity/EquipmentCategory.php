<?php

namespace HOEquipmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipmentCategory
 *
 * @ORM\Table(name="equipment_category")
 * @ORM\Entity(repositoryClass="HOEquipmentBundle\Repository\EquipmentCategoryRepository")
 */
class EquipmentCategory
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
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\EquipmentCategoryFamily")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $family;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\Equipment",mappedBy="category")
    */
    private $equipments;


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
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EquipmentCategory
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
     * Add equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return EquipmentCategory
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
     * Set family
     *
     * @param \HOEquipmentBundle\Entity\EquipmentCategoryFamily $family
     *
     * @return EquipmentCategory
     */
    public function setFamily(\HOEquipmentBundle\Entity\EquipmentCategoryFamily $family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family
     *
     * @return \HOEquipmentBundle\Entity\EquipmentCategoryFamily
     */
    public function getFamily()
    {
        return $this->family;
    }
}
