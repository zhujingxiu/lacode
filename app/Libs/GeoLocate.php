<?php
namespace App\Libs;

use GeoIp2\Database\Reader;
class GeoLocate
{
    public function __construct()
    {

        $reader = new Reader('/usr/local/share/GeoIP/GeoIP2-City.mmdb');
    }
}