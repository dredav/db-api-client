<?php

use ddreher\api\deutschebahn\DBClient;
use ddreher\api\deutschebahn\methods\Journey;
use ddreher\api\deutschebahn\methods\StationBoard;

require __DIR__ . '/../vendor/autoload.php';


$client = new DBClient([
    'authKey' => 'DBhackFrankfurt0316',
]);

foreach($client->request(StationBoard::create('008000026', new \DateTime(), StationBoard::DEPARTURE)) as $trainBoard)
{
    foreach($client->request(Journey::create($trainBoard->getJourneyData()['ref'])) as $stop) 
    {
        var_dump($stop);
    }
}