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

        const CRON_LOG_FILE = ABSPATH . "wp-content/plugins/dxl-core/dxl-cron.log";

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
            global $current_user;
            $logLevel = $this->setLogLevel($level);

            $logMessage = date("d-m-Y H:i:s", strtotime('now')) . " (" . $logLevel . ")";

            if( $current_user->user_login ) {
                $logMessage .= " " . $current_user->user_login;
            }

            $logMessage .= ", " . $message . " (dxl-" . $plugin . ")\r";

            if( is_file(self::LOGFILE) && file_exists(self::LOGFILE) ) {
	    		return file_put_contents(self::LOGFILE, $logMessage, FILE_APPEND);
	    	}

	    	touch(self::LOGFILE); 
	    	return file_put_contents(self::LOGFILE, $logMessage, FILE_APPEND);
        }

        /**
         * Log the message to the logfile
         *
         * @param string $message
         * @param string $plugin
         * @param integer $level
         * @return void
         */
        public function logCronReport(string $message, $level = 4)
        {
            $logLevel = $this->setLogLevel($level);
            
            $logMessage = date("d-m-Y H:i:s", strtotime('now')) . " (" . $logLevel . ") " . $message . "\r";

            if( is_file(self::CRON_LOG_FILE) && file_exists(self::CRON_LOG_FILE) ) {
	    		return file_put_contents(self::CRON_LOG_FILE, $logMessage, FILE_APPEND);
	    	}

	    	touch(self::CRON_LOG_FILE); 
	    	return file_put_contents(self::CRON_LOG_FILE, $logMmessage, FILE_APPEND);
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

                case 4: 
                    return "CRON";
                    break;
            }
        }
    }
}

?>