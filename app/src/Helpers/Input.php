<?php
namespace nasservb\AgencyAssistant\Helpers;

use nasservb\AgencyAssistant\Menu;

trait Input{

    /**
     * read number from terminal
     * @param null $prompt
     * @return int
     */
    public static  function readNumber($prompt = null ): int
    {
        $number = readline($prompt);
        while (!is_numeric($number)) {
            echo Menu::getInvalidMenu();
            $number = readline($prompt);
        }
        return $number;
    }

}
