<?php

namespace Sudoku\Infra\Adapter ;

use GuzzleHttp\ClientInterface;
use Ramsey\Uuid\Uuid ;

class EventStoreAdapter 
{
    private $client ;
    
    public function __construct(ClientInterface $httpClient)
    {
        $this->client = $httpClient ;
    }
    
    // add new event to a stream
    public function postEvent()
    {
        $eventname = "testme" ;
        $aggregateid = uniqid() ;
        $data = '{"id":"'.$aggregateid.'"}' ;
        $aggregate = "teststream" ;
        

        $headers["ES-EventType"] = $eventname ;
        $headers["ES-EventId"] =  (string) Uuid::uuid1() ;

        $response = $this->client->post($aggregate, ["headers" => $headers, "auth" => ["admin", "changeit"], "json" => $data ]) ;
//        echo "<pre>" ;
//        var_dump($response) ;
//        echo "</pre>" ;
    }
    
    public function getEvents()
    {
        $response = $this->client->get("teststream?embed=body", ["auth" => ["admin", "changeit"]]) ;
        $contents = json_decode($response->getBody()->getContents()) ;
        $events = $contents->entries ;
        
//        echo count($events) . "<br>" ;
//        $event = array_pop($events) ;
//        var_dump($event->data) ;
//        echo count($events) . "<br>" ;
        
        while(count($events) > 0)
        {
            echo count($events) ;
            $event = array_pop($events) ;
            echo "<pre>" ;
            var_dump($event->data) ;
            echo "</pre>" ;
        }
    }
    
}