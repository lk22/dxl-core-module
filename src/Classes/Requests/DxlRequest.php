<?php 
namespace Dxl\Classes\Requests;

if( !class_exists("DxlRequest") ) {
    abstract class DxlRequest {
        public $request;
        public function __construct()
        {
            $this->request = $_REQUEST;
        }

        public function verify_request_nonce()
        {
            
        }
        public abstract function get($field = '');
        public abstract function has($field): bool;
    }
}