<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 05.03.19
 * Time: 23:51
 */

namespace SphereMall\MS\Lib\Http\ElasticSearch;


use Elasticsearch\ClientBuilder;
use SphereMall\MS\Lib\Elastic\Builders\MSearch;
use SphereMall\MS\Lib\Elastic\Builders\Search;
use SphereMall\MS\Lib\Helpers\HttpHelper;

class Request extends \SphereMall\MS\Lib\Http\Request
{
    /**
     * @param string $method
     * @param bool   $body
     * @param bool   $uriAppend
     * @param array  $queryParams
     *
     * @return \GuzzleHttp\Promise\PromiseInterface|Response|\SphereMall\MS\Lib\Http\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(string $method, $body = false, $uriAppend = false, array $queryParams = [])
    {
        $client   = $this->createElasticClient();
        $param    = $queryParams[0];
        $endPoint = "search";

        if (is_a($param, Search::class)) {
            $endPoint    = "search";
            $queryParams = $param->getParams();

        } elseif (is_a($param, MSearch::class)) {
            $endPoint    = "msearch";
            $queryParams = $param->getParams();
        }

        try {
            $response = new Response($client->{$endPoint}($queryParams));
        } catch (\Exception $ex) {
            $error = json_decode($ex->getMessage());
            throw new \Exception($error->error->reason ?? $ex->getMessage());
        }

        return $response;
    }

    /**
     * @return \Elasticsearch\Client
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function createElasticClient()
    {
        $clientBuilder = new ClientBuilder();
        $url           = HttpHelper::setHttPortToUrl($this->client->getGatewayUrl(), false) . '/' . $this->resource->getVersion() . '/' . $this->resource->getURI();

        return $clientBuilder->setConnectionParams(['client' => ['headers' => $this->setAuthorization()]])
                             ->setHosts(['host' => $url])
                             ->build();
    }
}
