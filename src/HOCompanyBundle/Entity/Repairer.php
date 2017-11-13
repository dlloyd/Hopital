<?php

namespace HOCompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repairer
 *
 * @ORM\Table(name="repairer")
 * @ORM\Entity(repositoryClass="HOCompanyBundle\Repository\RepairerRepository")
 */
class Repairer
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
     * @ORM\Column(name="username", type="string")
     */
    private $username;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\RepairerStatus")
     */
    private $status;

    /**
    * @ORM\OneToMany(targetEntity="HOEquipmentBundle\Entity\EquipmentReparation", mappedBy="repairer", cascade={"persist"})
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
     * Set username
     *
     * @param string $username
     *
     * @return Repairer
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
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
     * @return Repairer
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
     * Set status
     *
     * @param \HOCompanyBundle\Entity\RepairerStatus $status
     *
     * @return Repairer
     */
    public function setStatus(\HOCompanyBundle\Entity\RepairerStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \HOCompanyBundle\Entity\RepairerStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}
