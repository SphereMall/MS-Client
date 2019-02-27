<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 9:35
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;
use SphereMall\MS\Lib\Elastic\Queries\FilterQuery;
use SphereMall\MS\Lib\Elastic\Queries\MatchQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustNotQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Queries\ShouldQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermsQuery;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class BoolQueriesTest extends SetUpResourceTest
{
    public function testMustQuery()
    {
        $query = new MustQuery([
            new TermsQuery("name", ["dd", "tt"]),
        ]);

        $this->assertInstanceOf(ElasticBodyElement::class, $query);
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

        $this->assertInstanceOf(ElasticBodyElement::class, $query);
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

        $this->assertInstanceOf(ElasticBodyElement::class, $query);
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

        $this->assertInstanceOf(ElasticBodyElement::class, $query);
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
