<?php
namespace nasservb\AgencyAssistant;
require  'vendor/autoload.php';

use nasservb\AgencyAssistant\Actions\Add;

class index
{    
    /**
     * start of the application is here !
     */
    public static function start()
    {
       (new Routes)->route();
    }  

}
index::start();
