<?php
namespace nasservb\AgencyAssistant\Controllers;

use nasservb\AgencyAssistant\Models\BaseEntity;
use nasservb\AgencyAssistant\Models\Place;
use nasservb\AgencyAssistant\Models\Transfer;

class TransferController extends BaseController
{

    public function search()
    {
        $this->checkLogin()->checkGetRequest();

        $sourcePlace = (new Place(''))->findById(intval($this->get('source_id')));
        
        if(!$sourcePlace->getId()>0) {
            return $this->render('the source_id is not valid!', 422);
        }

        $destinationPlace = (new Place(''))->findById($this->get('destination_id'));
        if(!$destinationPlace->getId()>0) {
            return $this->render('the destination_id is not valid!', 422);
        }
        
        if ($sourcePlace->getId() == $destinationPlace->getId()) {
            return $this->render('the source_id is equal to destination_id!', 422);
        }

        $startTime = strtotime($this->get('start_time'));
        if(is_bool($startTime)) {
            return $this->render('the start_time is not valid!', 422);
        }

        $endTime = strtotime($this->get('end_time'));
        if(is_bool($endTime)) {
            return $this->render('the end_time is not valid!', 422);
        }
        
        if ($startTime == $endTime) {
            return $this->render('the start_time is equal to end_time!', 422);
        }
       
        $transfers = Transfer::search(
            [
            'source_place' => $sourcePlace->getId(),
            'destination_place' => $destinationPlace->getId(),
            'start_time' => date('Y-m-d H:i:s', $startTime),
            'end_time' => date('Y-m-d H:i:s', $endTime)
            ]
        );

        return $this->render($transfers, 200);        
    }

    public function getTransferDetails()
    {
        $this->checkLogin()->checkGetRequest();
 
        $transfer = Transfer::getById(intval($this->get('id')));
        if(!$transfer ) {
            return $this->render('the id is not valid!', 422);
        }

        $user = $this->user->getCurrentUser(); 
        
        return $this->render(['role'=>$user->getUserType(), 'transfer'=>$transfer], 200);
    }

    public function getPlaces()
    {        
        $this->checkLogin()->checkGetRequest();

        $places =(new Place(''))->getAll();
        return $this->render($places, 200);
    }
       

    public function getVehicleClasses()
    {        
        $this->checkLogin()->checkGetRequest();

        $vehicleClasses =(new VehicleClass(''))->getAll();
        return $this->render($vehicleClasses, 200);
    }
}