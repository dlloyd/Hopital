<?php

namespace HOEquipmentBundle\Entity;


class MyDateTime extends \DateTime 
{
    public function __toString()
    {
        return $this->format('d/m/Y');
    }
}