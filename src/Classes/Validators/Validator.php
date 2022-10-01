<?php

namespace DXL\Core\Validators;

if(!class_exists('Validator'))
{
    class Validator {

        protected $request;

        public function __construct($request)
        {
            $this->request = $request; 
        }
        
        /**
         * Validate incomming request from request object
         *
         * @return void
         */
        public function validate()
        {
            $nonceValidated = $this->validateNonce();

            if ( ! $nonceValidated ) {
                return false;
            }

            $rules = $this->request->rules();
            $errors = [];
            
            foreach($rules as $key => $rule) {

                $ruleValidated = $this->ruleValidated($key, $rule);
                if ( ! $ruleValidated ) return false;
                
            }
            
            return true;
        }

        /**
         * check rule is validated
         * 
         * @return boolean
         */
        private function ruleValidated($rule, $value)
        {
            $rules = explode('|', $rule);
            $validated = true;

            foreach($rules as $rule) {
                $validated = $this->validateRule($rule, $value);
            }

            return $validated;
        }

        /**
         * Validate request key value is required
         *
         * @param [type] $value
         * @return boolean
         */
        private function isRequired(string $key, string $value)
        {
            if ( $this->request->rules[$key] == 'required' ) {
                return (!$this->isEmpty($value) && $value != null) ? true : false;
            }
        }

        /**
         * Validate request key value is valid email
         *
         * @param string $key
         * @param string $value
         * @return boolean
         */
        private function isEmail(string $key, string $value)
        {
            if ( $this->request->rules[$key] == 'email' ) {
                return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
            }
        }

        /**
         * Validate key value is numeric
         *
         * @param string $key
         * @param string $value
         * @return boolean
         */
        private function isNumeric(string $key, $value)
        {
            if ( $this->request->rules[$key] == 'numeric' ) {
                return is_numeric($value) ? true : false;
            }
        }

        /**
         * Valudate request key value is not empty
         *
         * @param [type] $key
         * @return boolean
         */
        private function hasValue(string $key) {
            return isset($this->request->{$key});
        }

        /**
         * Validator validate if the request contains nonce key value
         *
         * @return void
         */
        private function containsNonce() {
            return isset($_REQUEST['nonce']);
        }
    }
}