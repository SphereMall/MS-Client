<?php
/**
 * Project PHP-MS-Client.
 * File: ElasticsearchResource.php
 * Created by Sergey Yanchevsky
 * 15.02.2018 18:21
 */

namespace SphereMall\MS\Tests\_support;

use SphereMall\MS\Lib\Makers\ElasticMaker;

/**
 * Class ElasticsearchResource
 * @package SphereMall\MS\Tests\_support
 */
class ElasticsearchResource extends \SphereMall\MS\Resources\Elasticsearch\ElasticsearchResource
{
    /**
     * @param $response
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     */
    public function makeTest($response)
    {
        $this->maker = new ElasticMaker();

        return $this->make($response, true);
    }
}
