<?php

namespace nasservb\AgencyAssistant\Models;

use nasservb\AgencyAssistant\Database\DB;
class Booking extends BaseEntity implements IPrintable
{
    /**
     * @var string table nem on database 
     */
    protected $_table = 'books' ;

    /**
     * @var int
     */
    protected $user_id;

    /**
     * @var int
     */
    protected $booked_by;

    /**
     * @var int
     */
    protected $transfer_id;

    /**
     * @var int
     */
    protected $seats_booked;

    /**
     * @var int
     */
    protected $pickup_time;

    /**
     * @var float
     */
    protected $fare;
 
    /**
     * @param string $name
     * @param int $userId
     * @param Transfer $transfer
     * @param int $seatsBooked
     * @param int $bookedBy
     */
    public function __construct($userId, $transfer, $seatsBooked=0, $bookedBy=null)
    {
        $this->fare = $transfer['price_per_ticket'];
        $this->user_id = $userId;
        $this->booked_by = $bookedBy ? $bookedBy : $userId;
        $this->transfer_id = $transfer['id'];
        $this->seats_booked = $seatsBooked;
        $this->pickup_time =  date("Y-m-d H:i:s");
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }  

    /**
    * @param int $userId
    */
    public function setUserId(int $userId  )
    {
        $this->user_id= $userId;
    }

    /**
    * @return int
    */
    public function getTransferId()
    {
        return $this->transfer_id;
    }  

    /**
    * @param int $transferId
    */
    public function setTransferId(int $transferId  )
    {
        $this->transfer_id= $transferId;
    }

    /**
     * @return int
     */
    public function getBookedBy()
    {
        return $this->booked_by;
    }  

    /**
    * @param int $userId
    */
    public function setBookedBy(int $userId  )
    {
        $this->booked_by= $userId;
    }
    
    /**
     * @return int
     */
    public function getSeatsBooked()
    {
        return $this->seats_booked;
    }  

    public function setSeatsBooked(int $seats  )
    {
        $this->seats_booked= $seats;
    }
    
    /**
     * @return float
     */
    public function getFare()
    {
        return $this->fare;
    }  

    public function setFare(float $fare  )
    {
        $this->fare= $fare;
    }

    /**
     * @return DateTime
     */
    public function getPickupTime()
    {
        return $this->pickup_time;
    }  

    public function setPickupTime(DateTime $date  )
    {
        $this->pickup_time= $date;
    }

    public function print():string{
        return '';
    }

    public static function getBooksByUserId($userId){
        
        $query = 'SELECT 
                bk.id as id ,sr_place.name as source, 
                ds_place.name as destination,
                tr.start_time,tr.end_time, bk.fare,vc.name as vehicle_class 
                FROM `books` bk 
                INNER join transfers tr on bk.transfer_id = tr.id 
                INNER join places sr_place on tr.source_place_id = sr_place.id 
                INNER join places ds_place on tr.destination_place_id = ds_place.id 
                INNER join vehicle_classes vc on tr.vehicle_class_id = vc.id  
                where user_id = '. $userId; 
        return DB::run($query);
    }

    public static function getById($id){      

        $query = 'SELECT 
            bk.id as id ,sr_place.name as source, bk.pickup_time as pickup_time,
            ds_place.name as destination,bk.seats_booked as seats_booked,tr.passenger_capacity,
            tr.start_time,tr.end_time, bk.fare,vc.name as vehicle_class ,us.name as driver
            FROM `books` bk 
            INNER join transfers tr on bk.transfer_id = tr.id 
            INNER join places sr_place on tr.source_place_id = sr_place.id 
            INNER join places ds_place on tr.destination_place_id = ds_place.id 
            INNER join vehicle_classes vc on tr.vehicle_class_id = vc.id  
            left join users us on tr.executing_driver = us.id  
            where bk.id = '. $id; 
       
        $data =  DB::run($query);
        return is_array($data) ? $data[0] : null;
    }

}
