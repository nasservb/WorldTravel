<?php

namespace Tests\Integration;

use nasservb\AgencyAssistant\Services\HotelService;
use nasservb\AgencyAssistant\Controllers\BookingController;
use nasservb\AgencyAssistant\Models\Booking;
use nasservb\AgencyAssistant\Models\User;
use nasservb\AgencyAssistant\Database\DB;

use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    
    /**
     * @test
     */
    public function testBook()
    {
        /**
         * refresh database 
        */
        DB::init();

        $this->login();
        ob_start();
        $bookingController = new BookingController();

        $_SERVER['REQUEST_METHOD']= 'POST' ;
        $_POST = [
            'transfer_id'=>0
        ]; 
        $bookingController->book(); 
        $output1 = ob_get_clean();

        ob_start();
        $_POST = [
            'transfer_id'=>1 , 'user_id'=>0,'seats_no'=>0
        ]; 
        $bookingController->book(); 
        $output3 = ob_get_clean();

        ob_start();
        $_POST = [
            'transfer_id'=>1 , 'user_id'=>0,'seats_no'=>3
        ]; 
        $now =  date("Y-m-d H:i:s");

        $bookingController->book(); 
        $output4 = ob_get_clean();

        ob_end_flush();
        ob_get_clean();

        $this->assertEquals(json_decode($output1), 'the transfer is not valid!');
        $this->assertEquals(json_decode($output3), 'the seats_no is not valid!');
        $this->assertEquals($output4, '1');

        $bookOnDB= DB::run('select * from books where id =  '.DB::getLastInsertedId());

        $this->assertEquals($bookOnDB[0]['fare'], 12.65);
        $this->assertEquals($bookOnDB[0]['user_id'], 1);
        $this->assertEquals($bookOnDB[0]['booked_by'], 1);
        $this->assertEquals($bookOnDB[0]['transfer_id'], 1);
        $this->assertEquals($bookOnDB[0]['seats_booked'], 3);
        $this->assertEquals($bookOnDB[0]['pickup_time'], $now);
    }

      
    /**
     * @test
     */
    public function testGetBooks()
    {
        /**
         * refresh database 
        */
        DB::init();

        $this->login();
        ob_start();
        $bookingController = new BookingController();
        
        $bookingController->getBooks(); 
        $output = ob_get_clean();

        ob_start();
        (new User(''))->logout(); 
        $bookingController->getBooks(); 

        $output2 = ob_get_clean();

        ob_end_clean();

        $books= DB::run(
            'SELECT 
                bk.id as id ,sr_place.name as source, 
                ds_place.name as destination,
                tr.start_time,tr.end_time, bk.fare,vc.name as vehicle_class 
                FROM `books` bk 
                INNER join transfers tr on bk.transfer_id = tr.id 
                INNER join places sr_place on tr.source_place_id = sr_place.id 
                INNER join places ds_place on tr.destination_place_id = ds_place.id 
                INNER join vehicle_classes vc on tr.vehicle_class_id = vc.id  
                where user_id =1 '
        );

        $this->assertEquals(($output), json_encode($books));
        $this->assertEquals(json_decode($output2), 'Authentication required!');

    }

     /**
      * @test
      */
    public function testGetBookDetails()
    {
        /**
         * refresh database 
        */
        DB::init();

        $this->login();
        ob_start();
        $bookingController = new BookingController();
        
        $_GET = [
            'id'=>0
        ];
        $bookingController->getBookDetails(); 
        $output = ob_get_clean();
        ob_end_clean();

        ob_start();
        $_GET = [
            'id'=>1
        ];
        $bookingController->getBookDetails(); 
        $output2 = ob_get_clean();
        ob_end_clean();

        ob_start();
        (new User(''))->logout(); 
        $bookingController->getBooks(); 
        $output3 = ob_get_clean();

        ob_end_clean();

        $bookOnDB= DB::run('select * from books where id = 1 ');

        $this->assertEquals(json_decode($output), 'the id is not valid!');
        
        $book = json_decode($output2[0]);
        $this->assertEquals($bookOnDB['pickup_time'], $book[0]['pickup_time']);
        $this->assertEquals($bookOnDB['seats_booked'], $book[0]['seats_booked']);
        $this->assertEquals($bookOnDB['transfer_id'], $book[0]['transfer_id']);
        $this->assertEquals($bookOnDB['booked_by'], $book[0]['booked_by']);
        $this->assertEquals($bookOnDB['user_id'], $book[0]['user_id']);
        $this->assertEquals($bookOnDB['fare'], $book[0]['fare']);

        $this->assertEquals(json_decode($output3), 'Authentication required!');
    }


    private function login()
    {
        (new User(''))->login('nasser.niazymobsser@gmail.com', '12345678');
    }

}