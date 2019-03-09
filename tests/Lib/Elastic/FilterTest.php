<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 8:34
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Lib\Elastic\Builders\FilterBuilder;
use SphereMall\MS\Lib\Elastic\Filter\Config\BrandsConfig;
use SphereMall\MS\Lib\Elastic\Filter\Params\RangeParams;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class FilterTest extends SetUpResourceTest
{
    /**
     * @throws \Exception
     */
    public function testFilter()
    {
        $_SERVER['HTTP_HOST']   = 1;
        $_SERVER['REQUEST_URI'] = 2;

        $filter = new FilterBuilder();

        $filter->setConfigs([new BrandsConfig(true)])
               ->setEntities(['sm-products'])
               ->setParams([new RangeParams('fields', 'price', [
                   'gte' => 10000
               ])]);

        $result = $this->client->elastic()->filter($filter)->facets();
    }
}
