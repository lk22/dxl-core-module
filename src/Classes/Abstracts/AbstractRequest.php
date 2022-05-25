<?php 
namespace Dxl\Classes\Abstracts;

if( !class_exists("AbstractRequest") ) {
    abstract class AbstractRequest {
        
        /**
         * Request bag
         *
         * @var [type]
         */
        public $request;

        /**
         * Request Constructor
         */
        public function __construct()
        {
            $this->request = $_REQUEST;
        }

        /**
         * Verify nonce from request
         *
         * @return void
         */
        public function verify_nonce()
        {
            if( ! isset($this->request->request["dxl_core_nonce"]) && !wp_verify_nonce($this->request->request["dxl_core_nonce"], 'dxl-core-nonce') )
            {
                return false;
            }

            return true;
        }
        
        /**
         * Get value from field in request
         *
         * @param string $field
         * @return void
         */
        public abstract function get($field = '');

        /**
         * validate the request has field
         *
         * @param [type] $field
         * @return boolean
         */
        public abstract function has($field): bool;
    }
}