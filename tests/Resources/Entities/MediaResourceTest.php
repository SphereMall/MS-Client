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
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class MediaResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testServiceGetList()
    {
        $media = $this->client->media();
        $list = $media->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(Media::class, $item);
        }

    }
    #endregion
}
