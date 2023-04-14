<?php

namespace nasservb\AgencyAssistant;
require  'vendor/autoload.php';

use nasservb\AgencyAssistant\Actions\Add;
use nasservb\AgencyAssistant\Actions\Search;
use nasservb\AgencyAssistant\Helpers\Input;
use nasservb\AgencyAssistant\Database\DB;

class Main
{
    use Input;
    /**
     * start of the application is here !
     */
    public static function Start()
    {
        while (true) {
            echo Menu::getMainMenu();
            $number = static::readNumber();
            static::processMainMenu($number);
        }
    }

    /**
     * process main menu
     * @param $number
     */
    public static function processMainMenu($number)
    {
        switch ($number) {
          
            case 7 : //search
                DB::init();
                echo Menu::getCompleteMigration();
                break;
            case 8:
                exit(0);
                break;
        }
    }

}
Main::start();
