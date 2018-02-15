<?php
/**
 * Created by PHPStorm.
 * User: Serhey Yanchevsky
 * Email: s.yanchevsky@spheremall.com
 * Date: 12.02.1208
 * Time: 15:34
 */

namespace SphereMall\MS\Tests\Resources\Elastic;

use GuzzleHttp\Ring\Client\MockHandler;
use SphereMall\MS\Entities\Entity;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

/**
 * Class ElasticResourceTest
 * @package SphereMall\MS\Tests\Resources\Grapher
 */
class ElasticResourceTest extends SetUpResourceTest
{
    const MOCK = false;

    #region [Test methods]
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testServiceGetList()
    {
        $handler = new MockHandler([
            'status' => 200,
            'transfer_stats' => [
                'total_time' => 100
            ],
            'body' => fopen(__DIR__ . '/sm-products.json', 'r')
        ]);
        $ids = [9318, 6354, 6329];
        $urlCodes = ['limoen-komkommer-fruitwater', 'versmeergranen-ciabatta-oude-kaas', 'test-document'];

        if (self::MOCK) {
            $all = $this->client->elasticsearch()->search($handler);
        } else {
            $all = $this->client->elasticsearch()->search();
        }
        foreach ($all as $item) {
            $this->assertInstanceOf(Entity::class, $item);
            if (self::MOCK) {
                $this->assertTrue(isset($item->id));
                $this->assertTrue(isset($item->urlCode));
                $this->assertTrue(in_array($item->id, $ids));
                $this->assertTrue(in_array($item->urlCode, $urlCodes));
            }
        }
    }
    #endregion
}
