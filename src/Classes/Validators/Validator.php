<?php

namespace DXL\Core\Validators;

if(!class_exists('Validator'))
{
    abstract class Validator {
        protected $rules = [
            "fields" => [
                "field" => [
                    "name" => "",
                    "type" => "",
                    "action" => "",
                    "error" => ""
                ],
            ]
        ];

        public abstract function validate();
    }
}