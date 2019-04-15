<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 09.03.19
 * Time: 12:49
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Entities\Document;
use SphereMall\MS\Entities\Product;
use SphereMall\MS\Lib\Elastic\Aggregations\MaxAggregation;
use SphereMall\MS\Lib\Elastic\Builders\AggregationBuilder;
use SphereMall\MS\Lib\Elastic\Builders\BodyBuilder;
use SphereMall\MS\Lib\Elastic\Builders\FilterBuilder;
use SphereMall\MS\Lib\Elastic\Builders\QueryBuilder;
use SphereMall\MS\Lib\Elastic\Filter\Config\AttributesConfig;
use SphereMall\MS\Lib\Elastic\Filter\Config\BrandsConfig;
use SphereMall\MS\Lib\Elastic\Filter\Config\FunctionalNamesConfig;
use SphereMall\MS\Lib\Elastic\Filter\Factors\FilterFactorValue;
use SphereMall\MS\Lib\Elastic\Filter\Params\AttributesParams;
use SphereMall\MS\Lib\Elastic\Filter\Params\BrandsParams;
use SphereMall\MS\Lib\Elastic\Filter\Params\FunctionalNamesParams;
use SphereMall\MS\Lib\Elastic\Filter\Params\RangeParams;
use SphereMall\MS\Lib\Elastic\Queries\MustNotQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Queries\ShouldQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermsQuery;
use SphereMall\MS\Lib\Elastic\Sort\SortBuilder;
use SphereMall\MS\Lib\Elastic\Sort\SortElement;
use SphereMall\MS\Lib\Filters\FilterOperators;
use SphereMall\MS\Lib\Filters\Grid\EntityFilter;
use SphereMall\MS\Lib\Filters\Grid\FunctionalNameFilter;
use SphereMall\MS\Lib\Filters\Grid\GridFilter;
use SphereMall\MS\Lib\Helpers\ElasticSearchIndexHelper;
use SphereMall\MS\Lib\SortParams\ElasticSearch\ByFactorValues\Algorithms\DynamicFactors;
use SphereMall\MS\Lib\SortParams\ElasticSearch\ByFactorValues\Algorithms\MathSum;
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
//            new RangeParams('fields', 'price', ['gte' => 100]),
//            new RangeParams('attributes', 'color', ['lt' => 1]),
//            new FunctionalNamesParams([1, 2]),
//                        new AttributesParams('color', [1]),
//                        new AttributesParams('size', [2]),
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

        $data = $this->client->elastic()->msearch([$body])->all();
//        $data = $this->client->elastic()->search($body)->all();


        $this->assertTrue(true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testFilter()
    {
        $filter = new FilterBuilder();

        $filter->setConfigs([
            new AttributesConfig(['aantal pasjes', 'afmeeting']),
            new BrandsConfig(true),
            new FunctionalNamesConfig(true),
        ]);

        $filter->setEntities(ElasticSearchIndexHelper::getIndexesByClasses([Product::class]));
//        $filter->setParams([
//            new BrandsParams(['2']),
//        ]);
//        $filter->setGroupBy("variantsCompound");

//        $filterData = $this->client->elastic()->filter($filter)->facets();

        $body = new BodyBuilder();

        $filter->setFactors([
            new FilterFactorValue(10),
            new FilterFactorValue(3, 10),
        ]);

        $body->filter($filter)->limit(1)->offset(0);

        $resultData = $this->client->elastic()->search($body)->all();

        $this->assertTrue(true);
    }

    public function testSomeS()
    {
        $body  = new BodyBuilder();
        $query = (new QueryBuilder())->setMust(new MustQuery([
            new TermQuery('brandId', 2),
        ]));

        $body->query($query)->indexes(ElasticSearchIndexHelper::getIndexesByClasses([Product::class]));

        $data = $this->client->elastic()->search($body)->all();
        $this->assertTrue(true);
    }

    public function testFactorSort()
    {
        $script = (new MathSum([1, 2]))->getAlgorithm();
        $max    = (new MaxAggregation('_script'))->setScript($script);

        $aggs = new AggregationBuilder("factorSort", $max);

        $sortEl[] = new SortElement("_script", "asc", [
            'type'   => "number",
            'script' => $script,
        ]);

        $sort = new SortBuilder($sortEl);
        $this->assertTrue(true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testCorrelationsSearchByIds()
    {
        $query = new MustQuery([
            new TermQuery("visible", 1),
            new ShouldQuery([
                new MustQuery([
                    new TermQuery("_type", "products"),
                    new TermsQuery("_id", [1, 2]),
                ]),
                new MustQuery([
                    new TermQuery("_type", "documents"),
                    new TermsQuery("_id", [1, 2, 3]),
                ]),
            ]),
        ]);

        $body  = new BodyBuilder();
        $query = (new QueryBuilder())->setMust($query);

        $script = (new DynamicFactors([
            'products'  => [
                '2' => 0.2,
            ],
            'documents' => [
                '2' => 0.3,
                '1' => 0.4,
            ],
        ]))->getAlgorithm();

        $sort[] = new SortElement("_script", "desc", [
            'type'   => "number",
            'script' => $script,
        ]);

        $body->query($query)
             ->limit(1)
             ->offset(1)
             ->sort(new SortBuilder($sort))
             ->indexes(ElasticSearchIndexHelper::getIndexesByClasses([Product::class, Document::class]));

        $data = $this->client->elastic()->search($body)->withMeta()->all();

        $this->assertTrue(true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCorrelationsById()
    {
        $correlations = $this->client->correlations();
        $correlations->limit(1);

        $filter = new GridFilter();
        $filter->elements([
            new EntityFilter([Document::class]),
            new FunctionalNameFilter([26]),
        ]);
        $correlations->filter($filter);

        $data = $correlations->getById(1, Product::class);
        $this->assertTrue(true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetCorrelationsByIds()
    {
        $correlations = $this->client->correlations();
        $correlations->limit(1, 1);

        $filterParams = [
            'entity'          => ['documents'],
            'functionalNames' => [26, 27],
        ];

        $data = $correlations->getFromEntityByIds('products', [1], $filterParams);
        $this->assertTrue(true);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testWithOperators()
    {
        $body   = new BodyBuilder();
        $filter = new FilterBuilder();
        $filter->setParams([
            new BrandsParams([1], FilterOperators::NOT_IN),
            new FunctionalNamesParams([10], FilterOperators::NOT_IN)
        ]);

        $body->indexes(ElasticSearchIndexHelper::getIndexesByClasses([Product::class]))->filter($filter);

        $data = $this->client->elastic()->search($body)->all();

        $this->assertTrue(true);
    }
}
