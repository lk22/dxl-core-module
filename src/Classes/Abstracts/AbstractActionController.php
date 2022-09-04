<?php 
namespace Dxl\Classes\Abstracts;

include(ABSPATH . "wp-includes/pluggable.php");
if( !class_exists('AbstractActionController') )
{
    abstract class AbstractActionController 
    {
        /**
         * action rules
         *
         * @var array
         */
        protected $rules = [];

        /**
         * Rendering manage views 
         *
         * @return void
         */
        public abstract function manage();
        
        /**
         * Registering admin actions 
         *
         * @return void
         */
        public abstract function registerAdminActions();
        
        /**
         * registering guest actions
         *
         * @return void
         */
        public abstract function registerGuestActions();

        /**
         * Abstract action controller
         */
        public function __construct() 
        {
            // verify nonce before continuing with performing action
            $nonceVerified = $this->verify_nonce();
            if( ! $nonceVerified ) 
            {
                wp_die(401 . ' Unauthorized' );
            }
        }
        
        /**
         * validating request
         *
         * @param [type] $fields
         * @return void
         */
        public function validateRequest($requestModule) : bool
        {
            $module = $this->data[$requestModule];
            foreach($module as $f => $field) 
            {
                if( isset($this->rules[$f]) ) 
                {
                    // check if the field is required in the rules list and is not set in request 
                    if( ! in_array($f, $module) && $this->rules[$f] == "required") {
                        return false;
                    } else {
                        continue;
                    }

                    //check if the field is boolean value in the rules list and is not set in request 
                    if( $this->rules[$f] == "boolean" || $this->rules[$f] == "bool" ) 
                    {
                        if( ! is_bool($field) ) {
                            return false;
                        } else {
                            continue;
                        }
                    }
                }
            }
            return true;
        }
        
        /**
         * Verify nonce from request
         *
         * @return void
         */
        public function verify_nonce()
        {
            return ( isset($this->data["dxl_core_nonce"]) && !\wp_verify_nonce($this->data["dxl_core_nonce"], 'dxl-core-nonce') ) ? false : true;
        }


        public function data() 
        {
            return $_REQUEST;
        }

        /**
         * get key for action request
         *
         * @param [type] $key
         * @return void
         */
        protected function get($key) 
        {
            return isset($this->data[$key]) ? $this->data[$key] : false;
        }

        /**
         * Check if the key exists in request object
         *
         * @param [type] $key
         * @return boolean
         */
        protected function has($key) {
            return isset($this->data[$key]) ? true : false;
        }

        /**
         * Check if the uri key exists in the _GET superglobals array
         *
         * @param [type] $key
         * @return boolean
         */
        protected function hasUriKey($key) 
        {
            return isset($_GET[$key]) ? true : false;
        }

        /**
         * Get specific key from _GET superglobals array
         *
         * @param [type] $key
         * @return void
         */
        protected function getUriKey($key) 
        {
            return isset($_GET[$key]) ? $_GET[$key] : "";
        }

        /**
         * validating required rule of each request
         *
         * @param string $field
         * @return void
         */
        private function validateRequired(string $field) : bool
        {
            if( $this->rules[$field]["rule"] == "required" )
            {
                return true;
            }

            return false;
        }

        /**
         * validating requst field is a number
         *
         * @param string $field
         * @return boolean
         */
        private function validateNumber(string $field) : bool
        {
            if( $this->rules[$field]["rule"] == "number" )
            {
                return true;
            }

            return false;
        }
    }
}

?>