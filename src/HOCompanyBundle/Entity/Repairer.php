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
     * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\RepairerStatus",fetch="EAGER")
     */
    private $status;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    /**
    * @ORM\OneToMany(targetEntity="HOInterventionBundle\Entity\Intervention", mappedBy="repairer", cascade={"persist"})
    */
    private $interventions;

    /**
    * @ORM\OneToMany(targetEntity="HOCompanyBundle\Entity\RepairerAbscence", mappedBy="repairer", cascade={"persist"})
    */
    private $abscences;


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

   

   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interventions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
    }

    /**
     * Add intervention
     *
     * @param \HOInterventionBundle\Entity\Intervention $intervention
     *
     * @return Repairer
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

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Repairer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    

    /**
     * Add abscence
     *
     * @param \HOCompanyBundle\Entity\RepairerAbscence $abscence
     *
     * @return Repairer
     */
    public function addAbscence(\HOCompanyBundle\Entity\RepairerAbscence $abscence)
    {
        $this->abscences[] = $abscence;

        return $this;
    }

    /**
     * Remove abscence
     *
     * @param \HOCompanyBundle\Entity\RepairerAbscence $abscence
     */
    public function removeAbscence(\HOCompanyBundle\Entity\RepairerAbscence $abscence)
    {
        $this->abscences->removeElement($abscence);
    }

    /**
     * Get abscences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAbscences()
    {
        return $this->abscences;
    }
}
