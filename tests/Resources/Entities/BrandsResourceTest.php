<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\Brand;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class BrandsResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        //Get all brands - limit 10
        $brands = $this->client->brands();
        $brandList = $brands->all();

        //Check amount
        $this->assertEquals(10, count($brandList));

        //Get id for first brand
        $ids[] = $brandList[0]->id;
        //Get brand by ids
        $brandList = $brands->ids($ids)->all();
        //Check amount
        $this->assertEquals(1, count($brandList));

        //Check is brands equal
        $this->assertEquals($ids, $brands->getIds());

        //Check instanceof brand class
        foreach ($brandList as $brand) {
            $this->assertInstanceOf(Brand::class, $brand);
        }
    }

    #endregion
}
