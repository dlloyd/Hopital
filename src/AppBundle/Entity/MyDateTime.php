<?php

namespace AppBundle\Entity;


class MyDateTime extends \DateTime 
{
    public function __toString()
    {
        return $this->format('U');
    }
}