# DataValidations
Neste projeto é feito tanto a validação de dados individuais, quando validação de formulários, onde é retornado todos os erros.

## Funcionalidades

- Validação de dados individuais
- Validação de dados de formulários

## Como fazer a validação de dados individuais

Verifica se é um array multidimensional: return bool;

```php
 \App\Lib\Validations::isArrayMultidimensional($array);
```

Verifica se existe: return bool;

```php
 \App\Lib\Validations::isFilled($data);
```

Verifica se é um valor númerico: return bool;

```php
\App\Lib\Validations::isNumeric($number);

```

Verifica se tem uma quantidade mínima de caracteres: return bool;

```php
\App\Lib\Validations::hasMinLenght($string);
```


## Validação de formulários

#### Exemplo de validação de um formulário

```php
    $validation = new ValidationsForm();
    $validation->setItemsForValidation($_POST);
    $validation->setListValidations(
      array(
        array('Nome', 'minLenght[5]'),
        array('Valor', 'numeric, required'),
        array('Parcelas', 'numeric'),
        array('typeMoviment', 'numeric'),
        array('Categoria', 'numeric'),
      )
    );
    if ($validation->isValid()) {
      return true;
    }
    $errors = implode('<br>', $validation->getErrors());
```
