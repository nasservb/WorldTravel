<?php

namespace nasservb\AgencyAssistant\Models;

use nasservb\AgencyAssistant\Database\DB;
class Transfer extends BaseEntity implements ISearchable
{
    /**
     * @var string table nem on database 
     */
    protected $_table = 'transfers' ;

    /**
     * @var int passenger capacity of car
     */
    protected $passenger_capacity;

    /**
     * @var int which class of the vehicle used to transfer
     */
    protected $vehicle_class_id;

    /**
     * @var float fare of transfer
     */
    protected $price_per_ticket;

    /**
     * @var User driver
     */
    protected $executing_driver;

    /**
     * @var int source place
     */
    protected $source_place_id;

    /**
     * @var int destination place
     */
    protected $destination_place_id;

    /**
     * @var DateTime start transfer date
     */
    protected $start_time;

    /**
     * @var DateTime end transfer date
     */
    protected $end_time;

    /**
     * @param Place        $source
     * @param Place        $destination
     * @param DateTime     $start
     * @param DateTime     $end
     * @param VehicleClass $vehicleClass
     * @param float        $price
     * @param int          $passengerCapacity
     */
    public function __construct($source,$destination, $start, $end, $vehicleClass,$price,  $passengerCapacity)
    {
        $this->source_place_id = $source->getId();
        $this->destination_place_id = $destination->getId();
        $this->start_time = $start;
        $this->end_time = $end;
        $this->vehicle_class_id = $vehicleClass->getId();
        $this->price_per_ticket = $price;
        $this->passenger_capacity = $passengerCapacity;
    }

    /**
     * @return int
     */
    public function getPassengerCapacity()
    {
        return $this->passenger_capacity;
    }

    /**
     * @param  int $passengerCapacity
     * @return void
     */
    public function setPassengerCapacity($passengerCapacity)
    {
        $this->passenger_capacity= $passengerCapacity;
    }

    /**
     * @return float
     */
    public function getPricePerTicket()
    {
        return $this->price_per_ticket;
    }

    /**
     * @param  float $price
     * @return void
     */
    public function setPricePerTicket($price)
    {
        $this->price_per_ticket = $price;
    }

    /**
     * @return DateTime
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param  DateTime $date
     * @return void
     */
    public function setStartTime($date)
    {
        $this->start_time = $date;
    }

    /**
     * @return DateTime
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param  DateTime $date
     * @return void
     */
    public function setEndTime($date)
    {
        $this->end_time = $date;
    }

    /**
     * @return User|null
     */
    public function getExecutingDriver()
    {
        return $this->executing_driver ? (new User())->findById($this->executing_driver) : null;
    }

    /**
     * @param  User $driver
     * @return void
     */
    public function setExecutingDriver($driver)
    {
        $this->executing_driver = $driver->getId();
    }

     /**
      * @return Place|null
      */
    public function getSourcePlace()
    {
        return $this->source_place_id ? (new Place())->findById($this->source_place_id) : null;
    }

    /**
     * @param  Place $source
     * @return void
     */
    public function setSourcePlace($place)
    {
        $this->source_place_id = $place->getId();
    }

     /**
      * @return Place|null
      */
    public function getDestinationPlace()
    {
        return $this->destination_place_id ? (new Place())->findById($this->destination_place_id) : null;
    }

    /**
     * @param  Place $destination
     * @return void
     */
    public function setDestinationPlace($place)
    {
        $this->destination_place_id = $place->getId();
    }

    /**
     * @param Array $filters
     * 
     * @return BaseEntity
     */
    public static function search($filters)
    {
        $query=sprintf(
            'SELECT 
            tr.id as id ,sr_place.name as source, 
            ds_place.name as destination,
            tr.start_time as start_time, tr.price_per_ticket as fare ,vc.name as vehicle_class 
            FROM `transfers` tr 
            INNER join places sr_place on tr.source_place_id = sr_place.id 
            INNER join places ds_place on tr.destination_place_id = ds_place.id 
            INNER join vehicle_classes vc on tr.vehicle_class_id = vc.id  '.
            ' where  '.
            '   tr.source_place_id =%u and '.
            '   tr.destination_place_id =%u and '.
            '   tr.start_time >=\'%s\' and '.
            '   tr.end_time <=\'%s\'', 
            $filters['source_place'],
            $filters['destination_place'],
            $filters['start_time'],
            $filters['end_time']
        );
          
        return DB::run($query);
    }

    public static function getById($id)
    {
        
        $query=sprintf(
            'SELECT 
                tr.id as id ,sr_place.name as source, tr.passenger_capacity, 
                ds_place.name as destination,u.name as driver,tr.end_time as end_time,
                tr.start_time as start_time, tr.price_per_ticket as fare ,vc.name as vehicle_class 
            FROM `transfers` tr 
            INNER join places sr_place on tr.source_place_id = sr_place.id 
            INNER join places ds_place on tr.destination_place_id = ds_place.id 
            INNER join vehicle_classes vc on tr.vehicle_class_id = vc.id  
            left join users u on tr.executing_driver = u.id '.
            ' where  '.
            '   tr.id =%u', 
            $id
        );
        $data =DB::run($query);           

        $seatQuery =sprintf('select seats_booked from books where transfer_id = %u', $id);
        $seats =DB::run($seatQuery);           

        return is_array($data) ? ['data'=>$data[0],'seats'=>$seats]: null;
    }

    public static function find($id)
    {
        
        $query=sprintf(
            'SELECT * from transfers '.
            ' where  '.
            '   id =%u', 
            $id
        );
        $data =DB::run($query);          
       
        return is_array($data) ? $data[0]: null;
    }

}
