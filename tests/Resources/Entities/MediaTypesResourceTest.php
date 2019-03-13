<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\Media;
use SphereMall\MS\Entities\MediaType;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class MediaTypesResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $mediaTypes = $this->client->mediaTypes();
        $list = $mediaTypes->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(MediaType::class, $item);
        }

    }
    #endregion
}
