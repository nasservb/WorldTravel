<?php

namespace nasservb\AgencyAssistant\Models;

class VehicleClass extends BaseEntity
{

    /**
     * @var string table nem on database 
     */
    protected $_table = 'vehicle_classes' ;

    /**
     * @var string icon name
     */
    protected $icon;

     /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    /**
     * @return string icon 
     */
    public function getIcon() 
    {
        return $this->icon;
    }

    /**
     * set the value of icon
     */
    public function setIcon($icon) 
    {
        return $this->icon = $icon;
    }

}
