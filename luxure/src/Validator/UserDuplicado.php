<?php

// src/Validator/FileSize.php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserDuplicado extends Constraint
{
    public $username_existe = 'O username {{ name }} já existe, insira outro.';
   
}
