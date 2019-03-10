<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 12:49
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Lib\Elastic\Builders\BodyBuilder;
use SphereMall\MS\Lib\Elastic\Builders\FilterBuilder;
use SphereMall\MS\Lib\Elastic\Filter\Config\BrandsConfig;
use SphereMall\MS\Lib\Elastic\Filter\Params\RangeParams;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class SimpleFilterTest extends SetUpResourceTest
{
    public function testBodyFilter()
    {
        $_SERVER['HTTP_HOST']   = 1;
        $_SERVER['REQUEST_URI'] = 2;

        $body   = new BodyBuilder();
        $filter = new FilterBuilder();

        $filter->setEntities(['sm-products']);
        $filter->setConfigs([new BrandsConfig(true)]);
        $filter->setParams([new RangeParams('fields', 'price', ['gte' => 100])]);
        $filter->setKeyword("DryCare", ['title_fr']);
        $filter->setGroupBy("variantsCompound");
//        $filter->setFactorsId();

//        $filter = $this->client->elastic()->filter($filter)->facets();

        $body->filter($filter);

        $this->client->elastic()->search($body)->all();
    }
}
