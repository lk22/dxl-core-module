<?php 

namespace Dxl\Classes\Utilities;

if(!class_exists('Logger'))
{
    class Logger 
    {
        /**
         * Logger instance
         *
         * @var Dxl\Classes\Utilities\Logger
         */
        private static $instance;

        /**
         * specified path to logfile
         */
        const LOGFILE = ABSPATH . "wp-content/plugins/dxl-core/dxl.log";

        /**
         * return a new or existing instance of the logger utility
         *
         * @return void
         */
        public static function getInstance()
        {
            if(!static::$instance) 
            {
                return new Logger();
            }

            return static::$instance;
        }

        /**
         * Log the message to the logfile
         *
         * @param string $message
         * @param string $plugin
         * @param integer $level
         * @return void
         */
        public function log(string $message, $plugin = "dxl", $level = 1)
        {
            $logLevel = $this->setLogLevel($level);
            $logMessage = date("d-m-Y H:i:s", strtotime('now')) . " (" . $logLevel . ") User: " . wp_get_current_user()->user_login . ", " . $message . " (dxl-" . $plugin . ")\r";

            if( is_file(self::LOGFILE) && file_exists(self::LOGFILE) ) {
	    		return file_put_contents(self::LOGFILE, $logMessage, FILE_APPEND);
	    	}

	    	touch(self::LOGFILE); 
	    	return file_put_contents(self::LOGFILE, $logMmessage, FILE_APPEND);
        }

        /**
         * Set a specific level for the incomming log entrance
         *
         * @param [type] $level
         * @return void
         */
        public function setLogLevel($level) {
            switch($level) {
                case 1: 
                    return "INFO";
                    break;
                case 2: 
                    return "ERROR";
                    break;
                case 3: 
                    return "API";
                    break;
            }
        }
    }
}

?>