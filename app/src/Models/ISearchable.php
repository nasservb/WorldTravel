<?php

namespace nasservb\AgencyAssistant\Models;

interface ISearchable 
{
    /**
    * @param string $name
    */
    public static function search($filters);
    
}
