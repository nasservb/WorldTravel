<?php
namespace nasservb\AgencyAssistant\Events;
use nasservb\AgencyAssistant\Events\BaseEvent;

class SendMail extends BaseEvent
{
    
    protected $queueName = 'mail' ;

    public function Fire($data)
    {
        $data =  [
            'message' => $data['message'], 
            'to'   => $data['to'],
            'subject'   => $data['subject'],
        ];
        $this->Send($data); 
    }
}
