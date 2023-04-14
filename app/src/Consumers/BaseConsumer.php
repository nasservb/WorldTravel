<?php
namespace nasservb\AgencyAssistant\Consumers;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage; 

abstract class BaseConsumer {
    private $channel ; 
    private $connection ; 

    public function __construct(){
        $this->connect(); 
    }

    private function connect(){
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'rabbitmq', '12345678');
        $this->channel = $connection->channel();
        return $this->connection; 
    }

    public function Waite(){

        $this->channel->queue_declare($this->queueName, false, false, false, false);

        $callback = $this->Receive;
          
        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);
        
        while ($this->channel->is_open()) {
            $this->channel->wait();
        }

    }
}
