<?php

use ddreher\api\deutschebahn\DBClient;
use ddreher\api\deutschebahn\methods\StationBoard;

require __DIR__ . '/../vendor/autoload.php';


$client = new DBClient([
	'authKey' => 'DBhackFrankfurt0316',
]);

foreach($client->request(StationBoard::createWithDirection('008000105', '008011160', new \DateTime(), StationBoard::DEPARTURE)) as $trainBoard)
{
	var_dump($trainBoard);
}