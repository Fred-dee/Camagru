<?php
    class Mailer
    {
        private $_to;
        private $_from;
        private $_headers;
        private $_message;
        private $_subject;
        private $_isSMTP = false;
        private $_SMTP_AUTH;
        private $_SMTP_PASS;
        private $_SMTP_PORT;
        private $_SMTP_SERVER;
        
        public function __construct()
        {
            
        }
        
        public function get_setting($var)
        {
            return ini_get($var);
        }
        
        public function set_variables($arr)
        {
            foreach ($arr as $key => $value)
            {
                switch(strtolower($key))
                {
                    case "to":
                        $this->_to = $value;
                        break;
                    case "from":
                        $this->_from = $value;
                        break;
                    case "headers":
                        $this->_headers = $value;
                        break;
                    case "message":
                        $this->_message = $value;
                        break;
                    case "issmtp":
                        $this->_isSMTP = $value;
                        break;
                    case "smpt_port":
                        $this->_SMTP_PORT = (int)$value;
                        break;
                    case "username":
                        $this->_SMTP_AUTH = $value;
                        break;
                    case "password":
                        $this->_SMTP_PASS = $value;
                        break;
                    case "server":
                        $this->_SMTP_SERVER = $value;
                        break;
                    case "subject":
                        $this->_subject = $value;
                        break;
                }
            }
        }
        
        public function send()
        {
            if ($this->_isSMTP == true)
            {
                ini_set("username", $this->_SMTP_AUTH);
                ini_set("password", $this->_SMTP_PASS);
                ini_set("smtp_port", $this->_SMTP_PORT);
                ini_set("SMTP", $this->_SMTP_SERVER);
                
                echo init_get("username");
            }
            if (!mail($this->_to, $this->_subject, $this->_message, "FROM: ".$this->_from))
                return (false);
            else
                return true;
                    //$bool = mail($to_email, $subject, $message, $headers);
        }     
           
    }
?>
