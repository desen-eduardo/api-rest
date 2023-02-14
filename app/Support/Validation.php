<?php

namespace App\Support;

class Validation
{
    private static $error = [];

    public static function validate(array $rules)
    {
        foreach ($rules as $key => $value) {
            $value = static::validationParameter($key,$value);
            
            if (static::validationOne($value)) {
                static::$value($key);
            }
            
            if (static::validationOneOrMany($value)) {
                $validations = explode('|',$value);

                foreach ($validations as $validation) {
                    static::$validation($key);
                }
            }
        }
    }

    private static function validationOne(string $field):bool
    {
        return substr_count($field,'|') === 0;
    }

    private static function validationOneOrMany(string $field)
    {
        return substr_count($field,'|') >= 1;
    }

    private static function validationParameter($field,$validation)
    {
        if (substr_count($validation,':') > 0) {
            $validations = explode('|',$validation);
        }

        if (isset($validations)) {
            foreach ($validations as $key => $value) {
                if (substr_count($value,':') > 0) {
                    list($validationParameter,$parameter) = explode(':',$value);
    
                    static::$validationParameter($field,$parameter);
    
                    unset($validations[$key]);
    
                    $validation = implode('|',$validations);
                }
            }
        }

        return $validation;
    }

    private static function required(string $field)
    {
        if (empty($_POST[$field])) {
            static::$error[$field][] = 'O campo não pode ser vazio';
        }
    }

    private static function min($field,$length)
    {
        if (strlen($_POST[$field]) < $length) {
            static::$error[$field][] = 'O campo não pode-se menor que '.$length.' caracteres';
        }
    }

    private static function email($field)
    {
        if (!filter_var($_POST[$field],FILTER_VALIDATE_EMAIL)) {
            static::$error[$field][] = 'E-mail invalido';
        }
    }

    public static function hasError():bool
    {
        return !empty(static::$error);
    }

    public static function getMessage():array
    {
       return static::$error;
    }
}