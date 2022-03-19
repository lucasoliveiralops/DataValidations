<?php

namespace App\Lib\Validations;

class Validate
{
  public static function isFilled($item): bool
  {
    if (!empty($item)) {
      return true;
    }
    return false;
  }

  public static function isArrayMultidimensional(array $array): bool
  {
    if (is_array($array[0])) {
      return true;
    }
    return false;
  }


  public static  function isNumeric($item): bool
  {
    if (is_numeric($item)) {
      return true;
    }
    return false;
  }

  public static function hasMinLenght($item, $qtdCharacteres): bool
  {
    if (preg_match('!\d+!', $qtdCharacteres, $minimumCharacters)) {
      $numberOfCharactersInString = strlen($item);
      if ($numberOfCharactersInString >= $minimumCharacters[0]) {
        return true;
      }
      return false;
    }
    throw new \Exception('Não foi informado o número mínimo de caracteres!');
  }

  public static function hasMaxLenght($item, $qtdCharacteres): bool
  {
    if (preg_match('!\d+!', $qtdCharacteres, $maximumCharacters)) {
      $numberOfCharactersInString = strlen($item);
      if ($numberOfCharactersInString <= $maximumCharacters[0]) {
        return true;
      }
      return false;
    }
    throw new \Exception('Não foi informado o número máximo de caracteres!');
  }
}
