<?php

namespace App\DBAL;

class EnumPersonType extends EnumType
{
    protected $name = 'enum_person';
    protected $values = array('physical', 'legal');
}