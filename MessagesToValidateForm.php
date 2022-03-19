<?php

namespace App\Lib\Validations;

class MessagesToValidateForm
{
  private static $messages = array(
    'isFilled' => 'O campo NAME_CAMPO não foi definido!',
    'isNumeric' => 'O campo NAME_CAMPO não é numérico!',
    'hasMinLenght' => 'O campo NAME_CAMPO não tem a quantidade mínima de caracteres!',
    'hasMaxLenght' => 'O campo NAME_CAMPO tem mais que a quantidade máxima de caracteres!',
    'isArrayMultidimensional' => 'O campo NAME_CAMPO não é um array/lista multidimensional.'
  );

  public static function getErrorMessage($method, $nameCampo)
  {
    if (self::$messages[$method]) {
      return preg_replace('/name_campo/i', $nameCampo, self::$messages[$method]);
    }
    throw new \Exception('Não foi encontrado mensagem para esse método!');
  }
}
