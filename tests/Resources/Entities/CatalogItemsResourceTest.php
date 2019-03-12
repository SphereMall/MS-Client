<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\CatalogItem;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class CatalogItemsResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testServiceGetList()
    {
        $entityAttributes = $this->client->catalogItems();
        $list = $entityAttributes->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(CatalogItem::class, $item);
        }

    }
    #endregion
}
