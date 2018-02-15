<?php
/**
 * Project PHP-MS-Client.
 * File: Elastic.php
 * Created by Sergey Yanchevsky
 * 14.02.2018 13:59
 */

namespace SphereMall\MS\Lib\Http;

use Elasticsearch\ClientBuilder;
use SphereMall\MS\Client;
use SphereMall\MS\Resources\Resource as ServiceResource;

/**
 * Class Elastic
 * @package SphereMall\MS\Lib\Http
 * @property Client $client
 * @property ServiceResource $resource
 */
class ElasticRequest
{
    #region [Properties]
    protected $client;
    protected $resource;
    #endregion

    #region [Constructor]
    /**
     * RequestHandler constructor.
     *
     * @param Client $client
     * @param ServiceResource $resource
     */
    public function __construct(Client $client, ServiceResource $resource)
    {
        $this->client   = $client;
        $this->resource = $resource;
    }
    #endregion

    #region [Public methods]
    /**
     * @param string $method
     * @param array  $params
     * @param bool   $mock
     *
     * @return ElasticResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(string $method, $params = [], bool $mock = false)
    {
        $method = strtolower($method);
        $clientBuilder = new ClientBuilder();
        if ($mock) {

        }
        $clientBuilder->setConnectionParams([
            'client' => [
                'headers' => $this->setAuthorization()
            ]
        ]);

        //Generate request URL
//        $url = $this->client->getGatewayUrl() . '/' . $this->resource->getVersion() . '/' . $this->resource->getURI();
        // TODO for test without GateWay
        $url = '192.168.53.72:9200';

        $clientBuilder->setHosts([$url]);
        $client = $clientBuilder->build();
        $params = array_merge($params, ['client' => [
            'timeout' => 20,        // second timeout
            'connect_timeout' => 20
        ]]);
        $response = $client->$method($params);

        //Return response
        return (new ElasticResponse($response))->$method();
    }
    #endregion

    #region [Private methods]
    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function setAuthorization()
    {
        $authToken = new AuthToken($this->client);
        list($token, $userAgent) = $authToken->getTokenData();

        return [
            'headers' => [
                'Authorization' => "Bearer $token",
                'User-Agent'    => $userAgent,
            ],
        ];
    }
    #endregion
}
