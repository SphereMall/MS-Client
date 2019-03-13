<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\ProductVariant;
use SphereMall\MS\Lib\Collection;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class ProductVariantsResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $productVariants = $this->client->productVariants();
        $productArray = $productVariants->all();
        $productList = new Collection($productArray);

        $this->assertEquals(10, $productList->count());

        foreach ($productList as $product) {
            $this->assertInstanceOf(ProductVariant::class, $product);
        }
    }

    #endregion
}
