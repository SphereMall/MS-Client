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
use SphereMall\MS\Lib\Elastic\Builders\QueryBuilder;
use SphereMall\MS\Lib\Elastic\Filter\Config\AttributesConfig;
use SphereMall\MS\Lib\Elastic\Filter\Config\BrandsConfig;
use SphereMall\MS\Lib\Elastic\Filter\Config\FunctionalNamesConfig;
use SphereMall\MS\Lib\Elastic\Filter\Params\AttributesParams;
use SphereMall\MS\Lib\Elastic\Filter\Params\FunctionalNamesParams;
use SphereMall\MS\Lib\Elastic\Filter\Params\RangeParams;
use SphereMall\MS\Lib\Elastic\Queries\MustNotQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermsQuery;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class SimpleFilterTest extends SetUpResourceTest
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testBodyFilter()
    {
        $_SERVER['HTTP_HOST']   = 1;
        $_SERVER['REQUEST_URI'] = 2;

        $body   = new BodyBuilder();
        $filter = new FilterBuilder();

        $filter->setEntities(['sm-products']);
        $filter->setConfigs([
            new BrandsConfig(true),
        ]);
        $filter->setParams([
            new RangeParams('fields', 'price', ['gte' => 100]),
            //            new RangeParams('attributes', 'color', ['lt' => 1]),
            //            new FunctionalNamesParams([1, 2]),
            //            new AttributesParams('color', [1]),
            //            new AttributesParams('size', [2]),
        ]);
         //$filter->setKeyword("DryCare", ['title_fr']);
//        $filter->setGroupBy("variantsCompound");
//        $filter->setFactorsId([1]);

        //$filter = $this->client->elastic()->filter($filter)->facets();

        $body->filter($filter);
        $body->query(
            (new QueryBuilder())->setMust(
                new MustQuery([
                    new TermQuery('variantsCompound', '73c7ee10-2694-e59a-6e4e-5d7d6267591c'),
                ])
            )
        )->limit(1)->offset(1);

        $data = $this->client->elastic()->search($body)->withMeta()->all();
        $r    = 1;
    }
}
