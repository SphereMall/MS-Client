<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\Option;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class OptionsResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $entities = $this->client->options();
        $list = $entities->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(Option::class, $item);
        }

    }
    #endregion
}
