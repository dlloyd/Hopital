<?php

namespace HOCompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RepairerAbscence
 *
 * @ORM\Table(name="repairer_abscence")
 * @ORM\Entity(repositoryClass="HOCompanyBundle\Repository\RepairerAbscenceRepository")
 */
class RepairerAbscence
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
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Repairer",inversedBy="abscences")
    */
    private $repairer;

    /**
     * @ORM\Column(name="date_begin", type="datetime", nullable=false)     
     */
    private $dateBegin;


    /**
     * @ORM\Column(name="date_end", type="datetime", nullable=false)     
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="text",nullable=true)
     */
    private $motif;


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
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     *
     * @return RepairerAbscence
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return RepairerAbscence
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set repairer
     *
     * @param \HOCompanyBundle\Entity\Repairer $repairer
     *
     * @return RepairerAbscence
     */
    public function setRepairer(\HOCompanyBundle\Entity\Repairer $repairer = null)
    {
        $this->repairer = $repairer;

        return $this;
    }

    /**
     * Get repairer
     *
     * @return \HOCompanyBundle\Entity\Repairer
     */
    public function getRepairer()
    {
        return $this->repairer;
    }

    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return RepairerAbscence
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }
}
