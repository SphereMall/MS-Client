<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\AttributeGroup;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class AttributeGroupsResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $attributeGroups = $this->client->attributeGroups();
        $list = $attributeGroups->all();

        foreach ($list as $group) {
            $this->assertInstanceOf(AttributeGroup::class, $group);
        }
    }

    #endregion
}
