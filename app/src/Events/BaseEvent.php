<?php
namespace nasservb\AgencyAssistant\Events;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


abstract class BaseEvent
{
    private $channel ; 
    private $connection ; 

    public function __construct()
    {
        $this->connect(); 
    }

    private function connect()
    {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'rabbitmq', '12345678');
        $this->channel = $connection->channel();
        return $this->connection; 
    }

    public function Send($data)
    {

        $this->channel->queue_declare($this->queueName, false, false, false, false);

        $msg = new AMQPMessage(json_decode($data));
        $this->channel->basic_publish($msg, '', $this->queueName);

        $this->channel->close();
        $this->connection->close();
    }
}
