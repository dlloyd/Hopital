<?php

namespace AppBundle\Form\Type;


use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use AppBundle\Entity\MyDateTime;

class MyDateTimeType extends DateTimeType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        if ( ! $dateTime) {
            return $dateTime;
        }

        return new MyDateTime('@' . $dateTime->format('U'));
    }

    public function getName()
    {
        return 'mydatetime';
    }
}