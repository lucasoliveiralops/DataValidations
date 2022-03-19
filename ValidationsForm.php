<?php

namespace App\Lib\Validations;

class ValidationsForm extends Validate
{
  private $itemsForValidation, $listValidations,
    $listValidationsIsArrayMultidimensional, $messageError = array();

  private  $typesValidation = array(
    array(
      'nameValidation' => 'required',
      'methodResponsibleForValidation' => 'isFilled'
    ),
    array(
      'nameValidation' => 'numeric',
      'methodResponsibleForValidation' => 'isNumeric'
    ),
    array(
      'nameValidation' => 'minLenght',
      'methodResponsibleForValidation' => 'hasMinLenght'
    ),
    array(
      'nameValidation' => 'maxLenght',
      'methodResponsibleForValidation' => 'hasMaxLenght'
    ),
    array(
      'nameValidation' => 'arayMultidimensional',
      'methodResponsibleForValidation' => 'isArrayMultidimensional'
    ),
  );

  private function setItemsForValidation($items)
  {
    $this->itemsForValidation = $items;
  }

  private function setListValidations($validations)
  {
    if (self::isArrayMultidimensional($validations)) {
      foreach ($validations as $key => $item) {
        $this->listValidations[$key]['nameKeyItem'] = $item[0];
        $this->listValidations[$key]['nameValidation'] = $item[1];
      }
      $this->listValidationsIsArrayMultidimensional = true;
    } else {
      $this->listValidationsIsArrayMultidimensional = false;
      $this->listValidations['nameKeyItem'] = $validations[0];
      $this->listValidations['nameValidation'] = $validations[1];
    }
  }
  private  function hasMultipleValidations($validations): bool
  {
    $validationsList = explode(',', $validations);
    if (count($validationsList) > 1) {
      return true;
    }
    return false;
  }

  private  function getMethodResponsibleForValidation($validation)
  {
    $filterValidation = trim($validation);
    $filterValidation = explode('[', $filterValidation)[0];
    foreach ($this->typesValidation as $itemOfValidation) {
      if ($itemOfValidation['nameValidation'] == $filterValidation) {
        return $itemOfValidation['methodResponsibleForValidation'];
      }
    }
    throw new \Exception('Método para validação não encontrado!');
  }
  private function canValidateTheEmptyItem($nameMethod, $valueToBeValidated)
  {
    if ($nameMethod != 'isFilled' && empty($valueToBeValidated)) {
      return false;
    }
    return true;
  }
  private function makeValidation($item, $validation)
  {
    $method = $this->getMethodResponsibleForValidation($validation['nameValidation']);
    $keyItem = $validation['nameKeyItem'];
    $valueToBeValidated = isset($item[$keyItem]) ? $item[$keyItem] : NULL;
    if ($this->canValidateTheEmptyItem($method, $valueToBeValidated)) {
      if (!self::$method($valueToBeValidated, $validation['nameValidation'])) {
        $this->messageError[] =
          MessagesToValidateForm::getErrorMessage($method, $keyItem);
        return false;
      }
      return true;
    }
    return true;
  }

  private  function makeValidationArrayList($item, $validations)
  {
    $validations['nameValidation'] = explode(',', $validations['nameValidation']);
    foreach ($validations['nameValidation'] as $key => $validation) {
      $itemValidation = $validations;
      $itemValidation['nameValidation'] = $validations['nameValidation'][$key];
      $this->makeValidation($item, $itemValidation);
    }
  }

  private  function isValidItem($itens, array $validations)
  {
    if ($this->hasMultipleValidations($validations['nameValidation'])) {
      $this->makeValidationArrayList($itens, $validations);
    } else {
      $this->makeValidation($itens, $validations);
    }
  }

  private  function isValidArrayList()
  {
    foreach ($this->listValidations as $validations) {
      $this->isValidItem($this->itemsForValidation, $validations);
    }
  }

  public  function isValid($itens, array $validations)
  {
    if (!empty($itens) && !empty($validations)) {
      $this->setItemsForValidation($itens);
      $this->setListValidations($validations);
      if ($this->listValidationsIsArrayMultidimensional) {
        $this->isValidArrayList();
      } else {
        $this->isValidItem($this->itemsForValidation, $this->listValidations);
      }
      if ($this->messageError) {
        return $this->messageError;
      }
      return true;
    }
    throw new \Exception('Itens para valiação inválidos');
  }
}
