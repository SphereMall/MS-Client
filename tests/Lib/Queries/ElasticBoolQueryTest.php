<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:48
 */

namespace SphereMall\MS\Tests\Lib\Queries;


use SphereMall\MS\Lib\Queries\Elastic\FilterQuery;
use SphereMall\MS\Lib\Queries\Elastic\MatchQuery;
use SphereMall\MS\Lib\Queries\Elastic\MustNotQuery;
use SphereMall\MS\Lib\Queries\Elastic\MustQuery;
use SphereMall\MS\Lib\Queries\Elastic\ShouldQuery;
use SphereMall\MS\Lib\Queries\Elastic\TermsQuery;
use SphereMall\MS\Lib\Queries\Interfaces\ElasticBoolQueryInterface;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class ElasticBoolQueryTest extends SetUpResourceTest
{
    public function testMustQuery()
    {
        $query = new MustQuery([
            new TermsQuery("name", ["dd", "tt"]),
        ]);

        $this->assertInstanceOf(ElasticBoolQueryInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'bool' => [
                'must' => [
                    [
                        'terms' => [
                            'name' => ["dd", "tt"],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testShouldQuery()
    {
        $query = new ShouldQuery([
            new MatchQuery("name", "dd"),
        ]);

        $this->assertInstanceOf(ElasticBoolQueryInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'bool' => [
                'should' => [
                    [
                        'match' => [
                            'name' => [
                                "query"    => "dd",
                                "operator" => "and",
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testFilterQuery()
    {
        $query = new FilterQuery([
            new MatchQuery("name", "dd"),
        ]);

        $this->assertInstanceOf(ElasticBoolQueryInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'bool' => [
                'filter' => [
                    [
                        'match' => [
                            'name' => [
                                "query"    => "dd",
                                "operator" => "and",
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testMustNotQuery()
    {
        $query = new MustNotQuery([
            new MatchQuery("name", "dd"),
        ]);

        $this->assertInstanceOf(ElasticBoolQueryInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'bool' => [
                'must_not' => [
                    [
                        'match' => [
                            'name' => [
                                "query"    => "dd",
                                "operator" => "and",
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}

