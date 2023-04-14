<?php
namespace nasservb\AgencyAssistant\Controllers;

use nasservb\AgencyAssistant\Models\BaseEntity;

class DefaultController extends BaseController
{

    public function index()
    {
        header('Location: /front/');
        return  $this->render('this is the default controller');
    }

    public function error($code)
    {
        switch ($code) {
        case 404:
            $this->render('the requested url is not found!', 404);
            break;

        case 500:      
        default:
            $this->render('unknown error occurred!', 500);
            break;
        }
    }

}
