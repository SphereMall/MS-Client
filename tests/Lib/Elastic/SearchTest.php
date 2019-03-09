<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 06.03.19
 * Time: 0:32
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Lib\Elastic\Builders\BodyBuilder;
use SphereMall\MS\Lib\Elastic\Builders\QueryBuilder;
use SphereMall\MS\Lib\Elastic\Queries\MustNotQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Queries\RangeQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermQuery;
use SphereMall\MS\Lib\Elastic\Queries\TermsQuery;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class SearchTest extends SetUpResourceTest
{
    public function testSearch()
    {
        $body  = new BodyBuilder();
        $query = new QueryBuilder();

        $query->setMust(new MustQuery([
            new TermsQuery("name", ["dd", "tt"]),
            new TermQuery("brand", "BMW"),
            new MustNotQuery([
                new RangeQuery("price", ["gte" => 200]),
            ]),
        ]));

        $body->query($query)->limit(10)->offset(5);

        $this->assertEquals(10, $body->getLimit());
        $this->assertEquals(5, $body->getOffset());

        $this->assertEquals([
            "bool" => [
                "must" => [
                    [
                        "terms" => [
                            "name" => ["dd", "tt"],
                        ],
                    ],
                    [
                        "terms" => [
                            "brand" => ["BMW"],
                        ],
                    ],
                    [
                        "bool" => [
                            "must_not" => [
                                [
                                    "range" => [
                                        "price" => [
                                            "gte" => 200,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], $body->getQuery());

        $body2 = (new BodyBuilder())->query((new QueryBuilder())->setMust(new MustQuery([
            new TermQuery("visible", 1)
        ])))->indexes(["sm-products"])->source(["scope","visible"])->limit(1);


        $data = $this->client->elastic()->search($body2)->all();
//        $data = $this->client->elastic()->msearch([$body, $body2])->all();

    }
}
