<?php 

namespace App\DBAL;

class EnumGenderType extends EnumType
{
  protected $name = 'enum_gender';
  protected $values = array('male', 'female');
}