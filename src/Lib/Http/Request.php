<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:18
 */

namespace SphereMall\MS\Lib\Http;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Promise;
use SphereMall\MS\Client;
use SphereMall\MS\Entities\Entity;
use SphereMall\MS\Resources\Resource as ServiceResource;

/**
 * @property Client $client
 * @property ServiceResource $resource
 */
class Request
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
     * @param bool $body
     * @param bool $uriAppend
     * @param array $queryParams
     *
     * @return Promise\PromiseInterface|Response
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(string $method, $body = false, $uriAppend = false, array $queryParams = [])
    {
        $client = new \GuzzleHttp\Client();
        $async  = $this->client->getAsync();

        //Set user authorization
        $options = [];
        if (!$async) {
            $options = $this->setAuthorization();
        }

        //Generate request URL
        $url = $this->client->getGatewayUrl() . '/' . $this->resource->getVersion() . '/' . $this->resource->getURI();

        //Base url should end without slash
        $url = str_replace('?', '', $url);
        $url = rtrim($url, '/');

        //Append additional data to url
        if ($uriAppend) {
            $url = $url . '/' . $uriAppend;
        }

        //Add query params
        if ($queryParams) {
            $url = $url . '?' . urldecode(http_build_query($queryParams));
        }

        if ($body instanceof Entity) {
            $body = $body->asArray();
        }

        if ($body) {
            switch (strtolower($method)) {
                case 'put':
                    $options['body'] = http_build_query($body);
                    break;

                case 'post':
                    $options['content-type'] = 'application/x-www-form-urlencoded';
                    $options['form_params']  = $body;
                    break;

                case 'delete':
                    $options['body'] = http_build_query($body);
                    break;

            }
        }
        //Set statistic history for current call
        $this->client->setCallStatistic(compact('method', 'url', 'options'));

        //Check and generate async request if needed
        if ($async) {
            return compact('method', 'url', 'options');
        }

        //Call closure if existing
        if ($this->client->beforeAPICall) {
            call_user_func($this->client->beforeAPICall, $method, $url, $options);
        }

        //Return response
        return new Response($client->request($method, $url, $options));
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
