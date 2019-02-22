<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 16:23
 */

namespace SphereMall\MS\Tests\Lib\Filters;


use SphereMall\MS\Lib\Filters\Interfaces\ElasticFilterInterface;
use SphereMall\MS\Lib\Queries\Elastic\DistanceQuery;
use SphereMall\MS\Lib\Queries\Elastic\ExistsQuery;
use SphereMall\MS\Lib\Queries\Elastic\MatchPhraseQuery;
use SphereMall\MS\Lib\Queries\Elastic\MatchQuery;
use SphereMall\MS\Lib\Queries\Elastic\MultiMatchQuery;
use SphereMall\MS\Lib\Queries\Elastic\RangeQuery;
use SphereMall\MS\Lib\Queries\Elastic\RegexpQuery;
use SphereMall\MS\Lib\Queries\Elastic\TermQuery;
use SphereMall\MS\Lib\Queries\Elastic\TermsQuery;
use SphereMall\MS\Lib\Queries\Elastic\WildCardQuery;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class ElasticFiltersTest extends SetUpResourceTest
{
    public function testDistanceQuery()
    {
        $query = new DistanceQuery(10, 11, 10);
        $this->assertInstanceOf(ElasticFilterInterface::class, $query);

        $this->assertEquals($query->toArray(), [
            'geo_distance' => [
                'distance'     => "10km",
                'pin.location' => [
                    'lon' => 11,
                    'lat' => 10,
                ],
            ],
        ]);
    }

    public function testRegexpQuery()
    {
        $query = new RegexpQuery('name', 'd*d');

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'regexp' => [
                'name' => [
                    'value' => "d*d",
                ],
            ],
        ]);

        $query->setAdditionalParams(['flags' => "INTERSECTION|COMPLEMENT|EMPTY"]);

        $this->assertEquals($query->toArray(), [
            'regexp' => [
                'name' => [
                    'value' => "d*d",
                    'flags' => "INTERSECTION|COMPLEMENT|EMPTY",
                ],
            ],
        ]);
    }

    public function testExistsQuery()
    {
        $query = new ExistsQuery("name");

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'exists' => [
                'field' => 'name',
            ],
        ]);
    }

    public function testTermsQuery()
    {
        $query = new TermsQuery('name', ['Vasia', 'Petiya']);

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'terms' => [
                'name' => ['Vasia', 'Petiya'],
            ],
        ]);
    }

    public function testTermQuery()
    {
        $query = new TermQuery('name', 'Vasia');

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'terms' => [
                'name' => ["Vasia"],
            ],
        ]);
    }

    public function testRangeQuery()
    {
        $query = new RangeQuery('price', [
            'lte' => 100,
            'gte' => 10,
        ]);

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'range' => [
                'price' => [
                    'lte' => 100,
                    'gte' => 10,
                ],
            ],
        ]);
    }

    public function testWildCardQuery()
    {
        $query = new WildCardQuery('name', 'na*e');

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'wildcard' => [
                'name' => [
                    'value' => 'na*e',
                ],
            ],
        ]);

        $query->setAdditionalParams(['boost' => 2.0]);

        $this->assertEquals($query->toArray(), [
            'wildcard' => [
                'name' => [
                    'value' => 'na*e',
                    'boost' => 2.0,
                ],
            ],
        ]);
    }

    public function testMultiMatch()
    {
        $query = new MultiMatchQuery("query string", ["title", "name"]);

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            "multi_match" => [
                "query"    => "query string",
                "fields"   => ["title", "name"],
                "operator" => "and",
            ],
        ]);

        $query->setAdditionalParams(["type" => 'best_fields']);

        $this->assertEquals($query->toArray(), [
            "multi_match" => [
                "query"    => "query string",
                "fields"   => ["title", "name"],
                "operator" => "and",
                "type"     => "best_fields",
            ],
        ]);
    }

    public function testMatch()
    {
        $query = new MatchPhraseQuery("name", "ddi");

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            "match_phrase" => [
                "name" => [
                    "query" => "ddi",
                ],
            ],
        ]);

        $query->setAdditionalParams(['analyzer' => "my_analyzer"]);
        $this->assertEquals($query->toArray(), [
            "match_phrase" => [
                "name" => [
                    "query"    => "ddi",
                    "analyzer" => "my_analyzer",
                ],
            ],
        ]);
    }

    public function testMatchQuery()
    {
        $query = new MatchQuery("name", "dd");

        $this->assertInstanceOf(ElasticFilterInterface::class, $query);
        $this->assertEquals($query->toArray(), [
            'match' => [
                'name' => [
                    'query'    => 'dd',
                    'operator' => 'and',
                ],
            ],
        ]);

        $query->setAdditionalParams(['zero_terms_query' => 'all']);

        $this->assertEquals($query->toArray(), [
            'match' => [
                'name' => [
                    'query'            => 'dd',
                    'operator'         => 'and',
                    'zero_terms_query' => 'all',
                ],
            ],
        ]);
    }
}
