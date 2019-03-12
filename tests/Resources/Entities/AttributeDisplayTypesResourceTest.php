<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\AttributeDisplayType;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class AttributeDisplayTypesResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $attributeDisplayTypes = $this->client->attributeDisplayTypes();
        $list = $attributeDisplayTypes->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(AttributeDisplayType::class, $item);
        }
    }

    #endregion
}
