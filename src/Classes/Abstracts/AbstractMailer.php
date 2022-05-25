<?php 
namespace Dxl\Classes\Abstracts;

if( !class_exists('AbstractMailer') )
{
    abstract class AbstractMailer
    {
        /**
         * reciver email
         *
         * @var string
         */
        public $receiver = "";

        /**
         * Mail subject
         *
         * @var string
         */
        public $subject = "";

        /**
         * list of attachments to send with the email
         *
         * @var array
         */
        public $attachments = [];

        /**
         * array of headers to send within the mail
         *
         * @var array
         */
        public $headers = [];

        /**
         * view definition
         *
         * @var [type]
         */
        public $view = ABSPATH . "wp-content/plugins/";

        /**
         * Set reciever to sending mail
         *
         * @param [type] $reciever
         * @return void
         */
        public function setReciever($reciever)
        {
            $this->receiver = $reciever;
            return $this;
        }

        /**
         * set a mail subject to the mail
         *
         * @param [type] $subject
         * @return void
         */
        public function setSubject($subject)
        {
            $this->subject = $subject;
            return $this;
        }

        /**
         * Get subject value from object
         *
         * @return void
         */
        public function getSubject()
        {
            return $this->subject;
        }

        /**
         * Define a liste of custom headers send within the mail
         *
         * @param [type] $headers
         * @return void
         */
        public function setHeaders($headers) 
        {
            $this->headers = $headers;
        }

        /**
         * set mailer headers
         *
         * @return void
         */
        public function getHeaders()
        {
            return $this->headers;
        }

        /**
         * set a custom list of attachments to send with the mail
         *
         * @param [type] $attachments
         * @return void
         */
        public function setAttachments($attachments)
        {
            $this->attachments = $attachments;
            return $this;
        }

        /**
         * fetch attachments from mail object
         *
         * @return void
         */
        public function getAttachments()
        {
            return $this->attachments;
        }

        /**
         * set an view to send with the mail
         *
         * @param [type] $view
         * @return void
         */
        public function setView($view)
        {
            $this->view = $this->view . $view;
        }

        /**
         * make html support for each mail that is send
         *
         * @return void
         */
        public function setContentType() {
            return 'text/html';
        }

        /**
         * send method 
         *
         * @return void
         */
        public abstract function send();
    }
}


?>