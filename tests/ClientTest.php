<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 10/8/2017
 * Time: 4:52 PM
 */

namespace SphereMall\MS\Tests;

use SphereMall\MS\Client;
use SphereMall\MS\Lib\Http\Response;
use SphereMall\MS\Resources\Entities\ProductsResource;
use SphereMall\MS\Resources\Resource;

/**
 * Class ClientTest
 * @package SphereMall\MS\Tests
 */
class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testClientObjectCreatedNotConfigured()
    {
        $client = new Client();
    }

    /**
     * @throws \SphereMall\MS\Exceptions\ConfigurationException
     */
    public function testClientObjectCreatedWithConfiguration()
    {
        $client = new Client([
            'gatewayUrl' => API_GATEWAY_URL,
            'clientId'   => API_CLIENT_ID,
            'secretKey'  => API_SECRET_KEY,
            'version'    => API_VERSION,
        ]);

        $this->assertEquals(API_GATEWAY_URL, $client->getGatewayUrl());
        $this->assertEquals(API_CLIENT_ID, $client->getClientId());
        $this->assertEquals(API_SECRET_KEY, $client->getSecretKey());
        $this->assertEquals(API_VERSION, $client->getVersion());
    }

    /**
     * @throws \SphereMall\MS\Exceptions\ConfigurationException
     */
    public function testClientCallService()
    {
        $client = new Client([
            'gatewayUrl' => API_GATEWAY_URL,
            'clientId'   => API_CLIENT_ID,
            'secretKey'  => API_SECRET_KEY,
            'version'    => API_VERSION,
        ]);

        $productService = $client->products();

        $this->assertInstanceOf(Resource::class, $productService);
        $this->assertInstanceOf(ProductsResource::class, $productService);
    }

    /**
     * @throws \SphereMall\MS\Exceptions\ConfigurationException
     */
    public function testSetVersion()
    {
        $client = new Client([
            'gatewayUrl' => API_GATEWAY_URL,
            'clientId'   => API_CLIENT_ID,
            'secretKey'  => API_SECRET_KEY,
            'version'    => 'testV',
        ]);


        $this->assertEquals('testV', $client->getVersion());

        $client->setVersion('newV');
        $this->assertEquals('newV', $client->getVersion());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SphereMall\MS\Exceptions\ConfigurationException
     */
    public function testAfterApiCall()
    {
        $client = new Client([
            'gatewayUrl' => API_GATEWAY_URL,
            'clientId'   => API_CLIENT_ID,
            'secretKey'  => API_SECRET_KEY,
            'version'    => 'testV',
        ], null, function (Response $response) {
            $this->assertEquals(200, $response->getHttpStatusCode());
        });

        $client->products()->limit(1)->all();
    }
}
