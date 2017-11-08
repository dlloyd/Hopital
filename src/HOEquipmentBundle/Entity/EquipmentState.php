<?php

namespace HOEquipmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipmentState
 *
 * @ORM\Table(name="equipment_state")
 * @ORM\Entity(repositoryClass="HOEquipmentBundle\Repository\EquipmentStateRepository")
 */
class EquipmentState
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
     * @ORM\Column(name="state", type="string")
     */
    private $state;

    /**
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\Equipment",mappedBy="state")
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
     * Set state
     *
     * @param string $state
     *
     * @return EquipmentState
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add equipment
     *
     * @param \HOEquipmentBundle\Entity\Equipment $equipment
     *
     * @return EquipmentState
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
}
