<?php

namespace HOUserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="HOUserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\ManyToOne(targetEntity="HOCompanyBundle\Entity\Service",fetch="EAGER")
    * @ORM\JoinColumn(nullable=true)
    **/
    private $service;



    /**
     * Set service
     *
     * @param \HOCompanyBundle\Entity\Service $service
     *
     * @return User
     */
    public function setService(\HOCompanyBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \HOCompanyBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }
}
