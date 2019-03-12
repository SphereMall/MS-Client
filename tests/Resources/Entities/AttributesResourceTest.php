<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\Attribute;
use SphereMall\MS\Entities\Product;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class AttributesResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $attributes = $this->client->attributes();
        $list = $attributes->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(Attribute::class, $item);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \ReflectionException
     */
    public function testAttributesBelongEntityAttributeGroupAttribute()
    {
        $attributes = $this->client->attributes();
        $list = $attributes->belong(Product::class, 2, 1);

        foreach ($list as $item) {
            $this->assertInstanceOf(Attribute::class, $item);
        }
    }

    public function testAttributesBelongEntityAttributeGroup()
    {
        $attributes = $this->client->attributes();
        $list = $attributes->belong(Product::class, 2);

        foreach ($list as $item) {
            $this->assertInstanceOf(Attribute::class, $item);
        }
    }

    public function testAttributesBelongEntity()
    {
        $attributes = $this->client->attributes();
        $list = $attributes->belong(Product::class);

        foreach ($list as $item) {
            $this->assertInstanceOf(Attribute::class, $item);
        }
    }

    public function testAttributeHelpMethods()
    {
        $products = $this->client->products()
            ->limit(1)
            ->full();

        $attributes = $products[0]->attributes;
        foreach ($attributes as $attribute) {
            $this->assertInstanceOf(Attribute::class, $attribute);
        }

        $attribute = $attributes[0];
    }

    #endregion
}
