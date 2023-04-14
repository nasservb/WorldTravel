<?php

namespace nasservb\AgencyAssistant;

class Menu
{
    public static function getMainMenu()
    {
        return "Main Menu - Select an action:\n" .
            "7. Init DB(essential at first time running )\n" .
            "8. Exit\n";
    }

 

    public static function getCompleteMigration()
    {
        return ". drop tables\n" .
            ". create tables \n" .
            ". seed database with default data \n" .
            "process completed \n";
    }
}