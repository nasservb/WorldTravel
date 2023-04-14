<?php


namespace nasservb\AgencyAssistant\Models;

class Place extends BaseEntity implements ISearchable
{
    /**
     * @var string table nem on database 
     */
    protected $_table = 'places' ;

    /**
     * @var address
     */
    protected $address;

    /**
     * @var float location latitude
     */
    protected $locationLatitude = 0;

    /**
     * @var float location longitude
     */
    protected $locationLongitude = 0;

    /**
     * @param string $name
     * @param int    $address
     * @param float  $latitude
     * @param float  $longitude
     */
    public function __construct( $name, $address='', $latitude=0, $longitude=0)
    {
        $this->name = $name;
        $this->address = $address;
        $this->locationLatitude = $latitude;
        $this->locationLongitude = $longitude;
    }  

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return ['latitude'=>$this->locationLatitude , 'longitude' =>$this->locationLongitude] ;
    }

    /**
     * @param Array $filters
     * 
     * @return BaseEntity
     */
    public static function search($filters)
    {

    }

}
