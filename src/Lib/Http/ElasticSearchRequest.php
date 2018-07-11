<?php
/**
 * Created by PhpStorm.
 * User: DmitriyVorobey
 * Date: 19.02.2018
 * Time: 11:12
 */

namespace SphereMall\MS\Lib\Http;

use SphereMall\MS\Lib\Helpers\HttpHelper;
use SphereMall\MS\Elasticsearch\ClientBuilder;
use SphereMall\MS\Elasticsearch\Serializers\MultiJSONSerializer;

/**
 * Class ElasticSearchRequest
 * @package SphereMall\MS\Lib\Http
 */
class ElasticSearchRequest extends Request
{
    /**
     * @param string $method
     * @param bool $body
     * @param bool $uriAppend
     * @param array $queryParams
     *
     * @return \GuzzleHttp\Promise\PromiseInterface|ElasticSearchResponse|Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function handle(string $method, $body = false, $uriAppend = false, array $queryParams = [])
    {
        $clientBuilder = new ClientBuilder();
        $url           = HttpHelper::setHttPortToUrl($this->client->getGatewayUrl()) . '/' . $this->resource->getVersion() . '/' . $this->resource->getURI();
        $client = $clientBuilder->setConnectionParams(['client' => ['headers' => $this->setAuthorization()]])
                                ->setHosts(['host' => $url]);

        if(!empty($this->resource->filters)){
            $client->setSerializer(MultiJSONSerializer::class);
            $client->multi = true;
        }

        try {
            $response = new ElasticSearchResponse($client->build()->search($queryParams));
        } catch (\Exception $ex) {
            $error = json_decode($ex->getMessage());
            throw new \Exception($error->error->reason);
        }

        return $response;
    }
}
