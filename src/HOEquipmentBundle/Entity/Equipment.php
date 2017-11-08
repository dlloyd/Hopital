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
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\EquipmentState",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=false)
    */
    private $state;
    

    /**
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\Zone",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $zone;

    /**
    * @ORM\ManyToOne(targetEntity="HOEquipmentBundle\Entity\EquipmentCategory",inversedBy="equipments")
    * @ORM\JoinColumn(nullable=false)
    **/
    private $category;


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
     * Set state
     *
     * @param \HOEquipmentBundle\Entity\EquipmentState $state
     *
     * @return Equipment
     */
    public function setState(\HOEquipmentBundle\Entity\EquipmentState $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \HOEquipmentBundle\Entity\EquipmentState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zone
     *
     * @param \HOEquipmentBundle\Entity\Zone $zone
     *
     * @return Equipment
     */
    public function setZone(\HOEquipmentBundle\Entity\Zone $zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \HOEquipmentBundle\Entity\Zone
     */
    public function getZone()
    {
        return $this->zone;
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
}
