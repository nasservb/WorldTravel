<?php
namespace nasservb\AgencyAssistant\Controllers;

use nasservb\AgencyAssistant\Helpers\Security;

abstract class BaseController {
    use Security; 
    
    public function index(){

    }

    public function render($output,$headerCode=200)
    {
        if ($headerCode){
            http_response_code($headerCode);
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function post($key){
        if (isset($_POST[$key]))
        {
            return $this->clean($_POST[$key]);
        }

        $data = json_decode(file_get_contents('php://input'), true);
       
        if (isset($data[$key])) 
        {
            return $this->clean($data[$key]);
        }
        return '';
    }

    public function get($key){
        if (isset($_GET[$key]))
        {
            return $this->clean($_GET[$key]);
        }
        return '';
    }

    /**
     * @param string $key
     * @return cleaned string
     */
    public function clean($str){
        return $this->xss_clean($str);
    }

   

}