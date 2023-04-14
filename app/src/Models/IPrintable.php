<?php

namespace nasservb\AgencyAssistant\Models;

interface IPrintable
{
    /**
     * @return string base64 encoded picture
     */
    public function print():string;
    
}
