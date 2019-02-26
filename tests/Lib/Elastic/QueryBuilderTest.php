<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 26.02.2019
 * Time: 15:39
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Lib\Elastic\Builders\QueryBuilder;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;
use SphereMall\MS\Lib\Elastic\Queries\FilterQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustNotQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Queries\RangeQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermQuery;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class QueryBuilderTest extends SetUpResourceTest
{
    public function testQueryBuilder()
    {
        $builder = new QueryBuilder();

        $builder->setFilter(new FilterQuery([
            new TermQuery("name", "dd"),
        ]));

        $this->assertInstanceOf(ElasticBodyElement::class, $builder);

        $this->assertEquals([
            'bool' => [
                'filter' => [
                    [
                        'terms' => [
                            'name' => ['dd'],
                        ],
                    ],
                ],
            ],
        ], $builder->toArray());

        $builder = new QueryBuilder();

        $builder->setMust(new MustQuery([
            new TermQuery("name", "dd"),
            new MustNotQuery([
                new RangeQuery("price", [
                    "gte" => 100,
                ]),
            ]),
        ]));

        $this->assertEquals([
            'bool' => [
                'must' => [
                    [
                        'terms' => [
                            'name' => ['dd'],
                        ],
                    ],
                    [
                        'bool' => [
                            'must_not' => [
                                [
                                    'range' => [
                                        'price' => [
                                            'gte' => 100,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $builder->toArray());
    }
}
