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
use SphereMall\MS\Entities\SMEntity;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class EntitiesResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $entities = $this->client->entities();
        $list = $entities->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(SMEntity::class, $item);
        }

    }
    #endregion
}
