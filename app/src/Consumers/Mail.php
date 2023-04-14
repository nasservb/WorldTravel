<?php

namespace nasservb\AgencyAssistant\Consumers;

require  __DIR__ .'/../../vendor/autoload.php';

use nasservb\AgencyAssistant\Consumers\BaseConsumer;

class Mail extends BaseConsumer
{
    
    protected $queueName = 'mail' ;

    public function Receive($data)
    {
        
        //send_email($data['subject'], $data['to'],$data['message']);
        echo ' [x] Received ', json_decode($data->body), "\n";
    }
}

(New Mail)->Waite();
