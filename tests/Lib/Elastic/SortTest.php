<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 25.02.19
 * Time: 14:08
 */

namespace SphereMall\MS\Tests\Lib\Elastic;


use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;
use SphereMall\MS\Lib\Elastic\Sort\SortBuilder;
use SphereMall\MS\Lib\Elastic\Sort\SortElement;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class SortTest extends SetUpResourceTest
{
    public function testSortElement()
    {
        $sort = new SortElement("price");

        $this->assertInstanceOf(ElasticBodyElement::class, $sort);
        $this->assertEquals($sort->toArray(), [
            'price' => [
                'order' => 'asc',
            ],
        ]);

        $sort = new SortElement("price", "desc");

        $this->assertInstanceOf(ElasticBodyElement::class, $sort);
        $this->assertEquals($sort->toArray(), [
            'price' => [
                'order' => 'desc',
            ],
        ]);

        $sort = new SortElement("price", "desc", [
            "mode" => "avg",
        ]);

        $this->assertInstanceOf(ElasticBodyElement::class, $sort);
        $this->assertEquals($sort->toArray(), [
            'price' => [
                'order' => 'desc',
                'mode'  => 'avg',
            ],
        ]);
    }

    public function testSortBuilder()
    {
        $builder = new SortBuilder([
            new SortElement("price", "desc"),
            new SortElement("functionalNameId", "asc"),
            new SortElement("price", "desc", [
                "mode" => "avg",
            ]),
        ]);

        $this->assertInstanceOf(ElasticBodyElement::class, $builder);
        $this->assertEquals([
            'sort' => [
                [
                    "price" => [
                        'order' => 'desc',
                    ],
                ],
                [
                    'functionalNameId' => [
                        'order' => 'asc',
                    ],
                ],
                [
                    'price' => [
                        'order' => 'desc',
                        'mode'  => 'avg',
                    ],
                ],
            ],
        ], $builder->toArray());
    }
}
