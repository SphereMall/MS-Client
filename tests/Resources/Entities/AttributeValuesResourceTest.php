<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\AttributeValue;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class AttributeValuesResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $attributeValues = $this->client->attributeValues();
        $list = $attributeValues->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(AttributeValue::class, $item);
        }
    }

    #endregion
}
