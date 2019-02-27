<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 15:19
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Filters\GeoDistanceUnits;
use SphereMall\MS\Lib\Queries\Interfaces\ElasticQueryInterface;

/**
 * Class DistanceFilter
 *
 * @package SphereMall\MS\Lib\Filters\Elastic
 */
class DistanceQuery extends BasicQuery implements ElasticQueryInterface
{
    private $lat          = null;
    private $lon          = null;
    private $distance     = null;
    private $distanceUnit = null;

    /**
     * DistanceFilter constructor.
     *
     * @param        $lat
     * @param        $lon
     * @param        $distance
     * @param string $distanceUnit
     */
    public function __construct($lat, $lon, $distance, $distanceUnit = GeoDistanceUnits::KILOMETER)
    {
        $this->lat          = $lat;
        $this->lon          = $lon;
        $this->distance     = $distance;
        $this->distanceUnit = $distanceUnit;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'geo_distance' => [
                'distance'     => $this->distance . $this->distanceUnit,
                'pin.location' => [
                    'lat' => $this->lat,
                    'lon' => $this->lon,
                ],
            ],
        ];
    }
}
