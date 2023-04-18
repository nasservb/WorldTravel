<?php

namespace nasservb\AgencyAssistant\Tests\Integration;

use nasservb\AgencyAssistant\Services\HotelService;
use nasservb\AgencyAssistant\Controllers\TransferController;
use nasservb\AgencyAssistant\Models\Transfer;
use nasservb\AgencyAssistant\Models\Place;
use nasservb\AgencyAssistant\Models\VehicleClass;
use nasservb\AgencyAssistant\Database\DB;


class TransferTest extends BaseTest
{
    
    /**
     * @test
     */
    public function testSearch()
    {
        $this->refreshDatabase()->login()->prepareGetRequest();

        ob_start();
        $transferController = new TransferController();

        $_GET = [
            'source_id'=>0
        ]; 
        $transferController->search(); 
        $output1 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>0
        ]; 
        $transferController->search(); 
        $output2 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>1
        ]; 
        $transferController->search(); 
        $output3 = ob_get_clean();

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,
        ]; 
        $transferController->search(); 
        $output4 = ob_get_clean();
        
        $startDate = date_modify(date_create(),"-1 days")->format('Y-m-d');
        $endDate = date_modify(date_create(),"+1 days")->format('Y-m-d');

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,'start_time'=>$startDate
        ]; 
        $transferController->search(); 
        $output5 = ob_get_clean();


        $this->assertEquals(json_decode($output1), 'the source_id is not valid!');
        $this->assertEquals(json_decode($output2), 'the destination_id is not valid!');
        $this->assertEquals(json_decode($output3), 'the source_id is equal to destination_id!');
        $this->assertEquals(json_decode($output4), 'the start_time is not valid!');
        $this->assertEquals(json_decode($output5), 'the start_time must be in feature!');

        $startDate = date_modify(date_create(),"+1 days")->format('Y-m-d');
        $endDate = date_modify(date_create(),"+4 days")->format('Y-m-d');
        $source = (new Place(''))->findById(1) ; 
        $destination =(new Place(''))->findById(2); 
        $price= 13.65; 
        $passengerCapacity=3; 
        $vehicleClass =(new VehicleClass(''))->findById(1);
        
        $record = (new Transfer($source ,$destination, $startDate, $endDate, $vehicleClass,$price, $passengerCapacity))->save(); 
            
        var_export($record,true);

        ob_start();
        $_GET = [
            'source_id'=>1 , 'destination_id'=>2,'start_time'=>$startDate ,'end_time'=>''
        ]; 
        $transferController->search(); 
        $output6 = ob_get_clean();

        ob_end_clean();
      
        $searchResult = json_decode($output6,true);
        $this->assertEquals($searchResult[0]['id'], $record->getId());
        $this->assertEquals($searchResult[0]['source'], $source->getName());
        $this->assertEquals($searchResult[0]['destination'], $destination->getName());
        $this->assertEquals($searchResult[0]['fare'], $price);
        $this->assertEquals($searchResult[0]['vehicle_class'], $vehicleClass->getName() );
    }

      
    /**
     * @test
     */
    public function testGetTransferDetails()
    {
        
        $this->refreshDatabase()->login()->prepareGetRequest();

        ob_start();

        $transferController = new TransferController();
        
        $_GET = [
            'id'=>0
        ];
        $transferController->getTransferDetails();         
        $output = ob_get_clean();

        ob_start();
        $_GET = [
            'id'=>1
        ];
        $transferController->getTransferDetails();         
        $output2 = ob_get_clean();

       
        ob_end_clean();

        $this->assertEquals(json_decode($output), 'the id is not valid!');

        $transfer = json_decode($output2[0]);
        $transferOnDB= DB::run('select * from transfers where id =1');

        $this->assertEquals($transferOnDB['source_place_id'], $transfer[0]['source_place_id']);
        $this->assertEquals($transferOnDB['destination_place_id'], $transfer[0]['destination_place_id']);
        $this->assertEquals($transferOnDB['start_time'], $transfer[0]['start_time']);
        $this->assertEquals($transferOnDB['end_time'], $transfer[0]['end_time']);
        $this->assertEquals($transferOnDB['vehicle_class_id'], $transfer[0]['vehicle_class_id']);
        $this->assertEquals($transferOnDB['price_per_ticket'], $transfer[0]['price_per_ticket']);
        $this->assertEquals($transferOnDB['passenger_capacity'], $transfer[0]['passenger_capacity']);

    }

     /**
      * @test
      */
    public function testGetPlaces()
    {
        
        $this->refreshDatabase()->login()->prepareGetRequest();

        ob_start();
        $transferController = new TransferController();
        
        $transferController->getPlaces(); 
        $output = ob_get_clean();

        ob_end_clean();

        $places= DB::run('select * from places');
        
        $this->assertEquals($output, json_encode($places));
       
    }


}