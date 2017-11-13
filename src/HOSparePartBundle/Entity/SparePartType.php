<?php

namespace HOSparePartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SparePartType
 *
 * @ORM\Table(name="spare_part_type")
 * @ORM\Entity(repositoryClass="HOSparePartBundle\Repository\SparePartTypeRepository")
 */
class SparePartType
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
    * @ORM\OneToMany(targetEntity="HOSparePartBundle\Entity\SparePart", mappedBy="type", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    **/
    private $spareParts;


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
        $this->spareParts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return SparePartType
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
     * Add sparePart
     *
     * @param \HOSparePartBundle\Entity\SparePart $sparePart
     *
     * @return SparePartType
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
