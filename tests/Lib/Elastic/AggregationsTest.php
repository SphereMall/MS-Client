<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 15:47
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Lib\Elastic\Builders\AggregationBuilder;
use SphereMall\MS\Lib\Elastic\Aggregations\AvgAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\BucketSortAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\FiltersAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\MaxAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\MinAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\SumAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\TermsAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\TopHistAggregation;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticAggregationInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermsQuery;
use SphereMall\MS\Lib\Elastic\Sort\SortElement;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class AggregationsTest extends SetUpResourceTest
{
    public function testAvgAggregation()
    {
        $aggregation = new AvgAggregation("price");

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'avg' => [
                'field' => "price",
            ],
        ], $aggregation->toArray());

        $aggregation = new AvgAggregation("script");
        $aggregation->setScript([
            'id'     => 'my_script',
            'params' => [
                'field' => "grade",
            ],
        ]);
        $this->assertEquals([
            'avg' => [
                'script' => [
                    'id'     => "my_script",
                    'params' => [
                        'field' => 'grade',
                    ],
                ],
            ],
        ], $aggregation->toArray());

        $aggregation = new AvgAggregation("price");
        $aggregation->setAdditionalParams([
            "missing" => 10,
        ]);

        $this->assertEquals([
            'avg' => [
                'field'   => 'price',
                'missing' => 10,
            ],
        ], $aggregation->toArray());
    }

    public function testBucketSort()
    {
        $aggregation = new BucketSortAggregation(1);

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'bucket_sort' => [
                'from' => 0,
                'size' => 1,
            ],
        ], $aggregation->toArray());

        $aggregation = new BucketSortAggregation(1, 1);

        $this->assertEquals([
            'bucket_sort' => [
                'from' => 1,
                'size' => 1,
            ],
        ], $aggregation->toArray());

        $aggregation = new BucketSortAggregation(1, 1, [
            new SortElement("fieldName"),
            new SortElement("fieldName2", "desc"),
        ]);

        $this->assertEquals([
            'bucket_sort' => [
                'size' => 1,
                'from' => 1,
                'sort' => [
                    [
                        'fieldName' => [
                            'order' => 'asc',
                        ],
                    ],
                    [
                        'fieldName2' => [
                            'order' => 'desc',
                        ],
                    ],
                ],
            ],
        ], $aggregation->toArray());
    }

    public function testFilterAggregation()
    {
        $bool = new MustQuery([
            new TermsQuery("name", ["dd", "tt"]),
        ]);

        $aggregation = new FiltersAggregation("filterName", $bool);

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'filters' => [
                'filters' => [
                    'filterName' => [
                        'bool' => [
                            'must' => [
                                [
                                    'terms' => [
                                        'name' => [
                                            'dd',
                                            'tt',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $aggregation->toArray());
    }

    public function testMaxAggregation()
    {
        $aggregation = new MaxAggregation("price");

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'max' => [
                'field' => 'price',
            ],
        ], $aggregation->toArray());

        $aggregation = new MaxAggregation("script");
        $aggregation->setScript([
            'source' => "doc.price.value",
        ]);

        $this->assertEquals([
            'max' => [
                'script' => [
                    'source' => 'doc.price.value',
                ],
            ],
        ], $aggregation->toArray());

        $aggregation = new MaxAggregation("price");
        $aggregation->setAdditionalParams([
            'missing' => 10,
        ]);

        $this->assertEquals([
            'max' => [
                'field'   => 'price',
                'missing' => 10,
            ],
        ], $aggregation->toArray());
    }

    public function testMinAggregation()
    {
        $aggregation = new MinAggregation("price");

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'min' => [
                'field' => 'price',
            ],
        ], $aggregation->toArray());

        $aggregation = new MinAggregation("script");
        $aggregation->setScript([
            'source' => "doc.price.value",
        ]);

        $this->assertEquals([
            'min' => [
                'script' => [
                    'source' => 'doc.price.value',
                ],
            ],
        ], $aggregation->toArray());

        $aggregation = new MinAggregation("price");
        $aggregation->setAdditionalParams([
            'missing' => 10,
        ]);

        $this->assertEquals([
            'min' => [
                'field'   => 'price',
                'missing' => 10,
            ],
        ], $aggregation->toArray());
    }

    public function testSumAggregation()
    {
        $aggregation = new SumAggregation("price");

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'sum' => [
                'field' => 'price',
            ],
        ], $aggregation->toArray());

        $aggregation = new SumAggregation("script");
        $aggregation->setScript([
            'source' => "doc.price.value",
        ]);

        $this->assertEquals([
            'sum' => [
                'script' => [
                    'source' => 'doc.price.value',
                ],
            ],
        ], $aggregation->toArray());

        $aggregation = new SumAggregation("price");
        $aggregation->setAdditionalParams([
            'missing' => 10,
        ]);

        $this->assertEquals([
            'sum' => [
                'field'   => 'price',
                'missing' => 10,
            ],
        ], $aggregation->toArray());
    }

    public function testTermsAggregation()
    {
        $aggregation = new TermsAggregation("brandId");

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'terms' => [
                'field' => "brandId",
                "size"  => 10,
            ],
        ], $aggregation->toArray());

        $aggregation->setAdditionalParams([
            'show_term_doc_count_error' => true,
        ]);

        $this->assertEquals([
            'terms' => [
                'field'                     => "brandId",
                "size"                      => 10,
                "show_term_doc_count_error" => true,
            ],
        ], $aggregation->toArray());
    }

    public function testTopHistAggregation()
    {
        $aggregation = new TopHistAggregation();

        $this->assertInstanceOf(ElasticAggregationInterface::class, $aggregation);
        $this->assertEquals([
            'top_hits' => [
                'size' => 10,
                'from' => 0,
            ],
        ], $aggregation->toArray());

        $aggregation = new TopHistAggregation(20, 5);
        $this->assertEquals([
            'top_hits' => [
                'size' => 20,
                'from' => 5,
            ],
        ], $aggregation->toArray());

        $aggregation = new TopHistAggregation(10, 0, [
            new SortElement("sort_field_1"),
            new SortElement("sort_field_2", "desc"),
        ]);
        $this->assertEquals([
            'top_hits' => [
                'size' => 10,
                'from' => 0,
                'sort' => [
                    [
                        "sort_field_1" => [
                            'order' => 'asc',
                        ],
                    ],
                    [
                        "sort_field_2" => [
                            'order' => 'desc',
                        ],
                    ],
                ],
            ],
        ], $aggregation->toArray());

        $aggregation = new TopHistAggregation(10, 0, [], "price");
        $this->assertEquals([
            'top_hits' => [
                'size'    => 10,
                'from'    => 0,
                '_source' => "price",
            ],
        ], $aggregation->toArray());

    }

    public function testAggregationBuilder()
    {
        $aggregationBuilder = new AggregationBuilder("name", new TermsAggregation("name"));

        $this->assertInstanceOf(ElasticBodyElementInterface::class, $aggregationBuilder);
        $this->assertEquals([
            'name' => [
                'terms' => [
                    'field' => 'name',
                    'size'  => 10,
                ],
            ],
        ], $aggregationBuilder->toArray());

        $aggregationBuilder = new AggregationBuilder(
            "name",
            (new TermsAggregation("price"))->subAggregation(
                new AggregationBuilder("brand", new TermsAggregation("brand"))
            )
        );

        $this->assertEquals([
            'name' => [
                'terms' => [
                    'field' => 'price',
                    'size'  => 10,
                ],
                'aggs'  => [
                    'brand' => [
                        'terms' => [
                            'field' => 'brand',
                            'size'  => 10,
                        ],
                    ],
                ],
            ],
        ], $aggregationBuilder->toArray());
    }
}
