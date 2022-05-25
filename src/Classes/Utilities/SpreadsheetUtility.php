<?php 

    namespace Dxl\Classes\Utilities;
    
    require ABSPATH . "wp-content/plugins/dxl-core/PhpSpreadsheet/vendor/autoload.php";

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    if( !class_exists('SpreadsheetUtility') )
    {
        class SpreadsheetUtility {

            private static $instance;

            public static function getInstance()
            {
                if( !self::$instance ) return new SpreadsheetUtility();
                return self::$instance;
            }

            public function getSpreadsheet(): Spreadsheet
            {
                return new Spreadsheet;
            }

            public function getWriter(): Xlsx
            {
                return new Xlsx($this->getSpreadsheet());
            }

            public function getFill($style)
            {
                return Fill::$style;
            }
        }
    }

?>