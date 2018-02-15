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
class ElasticRequest extends  Request
{
    #region [Public methods]
    /**
     * @param string $method
     * @param bool|mixed $body
     * @param bool $uriAppend
     * @param array $queryParams
     *
     * @return ElasticResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(string $method, $body = false, $uriAppend = false, array $queryParams = [])
    {
        $method = strtolower($method);
        $clientBuilder = new ClientBuilder();
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
        $params = array_merge($queryParams, ['client' => [
            'timeout' => 20,        // second timeout
            'connect_timeout' => 20
        ]]);
        $response = $client->$method($params);

        //Return response
        return (new ElasticResponse($response))->$method();
    }
    #endregion
}
