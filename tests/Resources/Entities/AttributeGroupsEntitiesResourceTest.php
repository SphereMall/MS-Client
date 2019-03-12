<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\AttributeGroupsEntities;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class AttributeGroupsEntitiesResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $attributeGroupsEntities = $this->client->attributeGroupsEntities();
        $list = $attributeGroupsEntities->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(AttributeGroupsEntities::class, $item);
        }
    }

    #endregion
}
