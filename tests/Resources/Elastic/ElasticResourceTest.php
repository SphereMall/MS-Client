<?php
/**
 * Created by PHPStorm.
 * User: Serhey Yanchevsky
 * Email: s.yanchevsky@spheremall.com
 * Date: 12.02.1208
 * Time: 15:34
 */

namespace SphereMall\MS\Tests\Resources\Elastic;

use SphereMall\MS\Entities\Entity;
use SphereMall\MS\Lib\Http\ElasticResponse;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;
use SphereMall\MS\Tests\_support\ElasticsearchResource;

/**
 * Class ElasticResourceTest
 * @package SphereMall\MS\Tests\Resources\Grapher
 */
class ElasticResourceTest extends SetUpResourceTest
{
    protected $mockData = null;
    protected $ids = [9318, 6354, 6329];
    protected $urlCodes = ['limoen-komkommer-fruitwater', 'versmeergranen-ciabatta-oude-kaas', 'test-document'];

    public function setUp()
    {
        parent::setUp();

        $this->mockData = file_get_contents(__DIR__ . '/sm-products.json');
    }

    #region [Test methods]
    /**
     * @throws \Exception
     */
    public function testElasticResponse()
    {
        $response = (new ElasticResponse(json_decode($this->mockData, true)))->search();
        foreach ($response->getData() as $item) {
            $this->assertTrue(isset($item['id']));
            $this->assertTrue(isset($item['urlCode']));
            $this->assertTrue(in_array($item['id'], $this->ids));
            $this->assertTrue(in_array($item['urlCode'], $this->urlCodes));
        }
    }

    /**
     * @throws \Exception
     */
    public function testElasticResource()
    {
        $response = (new ElasticResponse(json_decode($this->mockData, true)))->search();
        $items = (new ElasticsearchResource($this->client))->makeTest($response);
        foreach ($items as $item) {
            $this->assertInstanceOf(Entity::class, $item);
            $this->assertTrue(isset($item->id));
            $this->assertTrue(isset($item->urlCode));
            $this->assertTrue(in_array($item->id, $this->ids));
            $this->assertTrue(in_array($item->urlCode, $this->urlCodes));
        }
    }
    #endregion
}
