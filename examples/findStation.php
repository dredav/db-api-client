<?php

use ddreher\api\deutschebahn\DBClient;
use ddreher\api\deutschebahn\methods\Stations;

require __DIR__ . '/../vendor/autoload.php';


$client = new DBClient([
    'authKey' => 'PutYourAPIKeyHere',
]);

foreach($client->request(Stations::create('Frankfurt (Main) Hbf')) as $station)
{
    var_dump($station);
}