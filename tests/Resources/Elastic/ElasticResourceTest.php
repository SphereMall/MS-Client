<?php
/**
 * Created by PHPStorm.
 * User: Serhey Yanchevsky
 * Email: s.yanchevsky@spheremall.com
 * Date: 12.02.1208
 * Time: 15:34
 */

namespace SphereMall\MS\Tests\Resources\Elastic;

use SphereMall\MS\Tests\Resources\SetUpResourceTest;

/**
 * Class ElasticResourceTest
 * @package SphereMall\MS\Tests\Resources\Grapher
 */
class ElasticResourceTest extends SetUpResourceTest
{
    #region [Test methods]

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testServiceGetList()
    {
        $all = $this->client->elasticsearch()->search();

        foreach ($all->getData() as $item) {
            $this->assertArrayHasKey('id', $item);
        }
    }
    #endregion
}
