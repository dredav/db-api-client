# db-api-client

This is a php client library for the deutsche bahn timetable API. The deutsche bahn is the biggest railway company in Germany and published in November 2015 the open data project which provides the data source. This project provides a client and wrapper classes for interaction with the API.

### Available data

At this state, there are only data available which belongs the long distance trains.

- [x] Station search
- [x] Departure Board
- [x] Arrivals board
- [x] Train route

## Usage

To install the client we recommended use composer.

**Install composer**
```bash
curl -sS https://getcomposer.org/installer | php
```

**Require the libary**
```bash
php composer.phar require ddreher/db-api-client
```

**Connect the composer autoloader**
```php
require 'vendor/autoload.php';
```

**Use the client**
```php
$client = new DBClient([
    'authKey' => 'PutYourAPIKeyHere',
]);

$client->request(...);
```

## Examples

This example will shows how to list all departing trains from Frankfurt (Main) Hauptbahnhof. The api returns the next 20 trains departing in the period between the submitted time and two hours.
```php
$client = new DBClient([
    'authKey' => 'PutYourAPIKeyHere',
]);

foreach($client->request(StationBoard::create('008000105', new \DateTime(), StationBoard::DEPARTURE)) as $trainBoard)
{
    var_dump($trainBoard);
}
```

For train station in Germany you can also use the short station id (e.g. remove the 008 and all leading 0), for Frankfurt (Main) Hauptbahnhof it will be 105. You can also determine the station id from the API, while searching train stations (see the example `examples/findStation.php`). All examples are available in the [examples folder][examples].

## Obtain API key

To obtain an API key, please read the instructions at http://data.deutschebahn.com/apis/fahrplan.

## Known issues

* One of the biggest issues is that all times from the API are published without timezone information. This is relevant for trains who's crossing multiple timezones.

## License

The API data from deutsche bahn are published under the Creative Commons Attribution 4.0 International (CC BY 4.0) license.

This library is published unter the MIT license.

[examples]: https://github.com/dredav/db-api-client/blob/master/examples/findStation.php
