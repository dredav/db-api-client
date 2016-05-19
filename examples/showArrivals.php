<?php

use ddreher\api\deutschebahn\DBClient;
use ddreher\api\deutschebahn\methods\StationBoard;

require __DIR__ . '/../vendor/autoload.php';


$client = new DBClient([
    'authKey' => 'PutYourAPIKeyHere',
]);

foreach($client->request(StationBoard::create('008000105', new \DateTime(), StationBoard::ARRIVAL)) as $trainBoard)
{
    var_dump($trainBoard);
}