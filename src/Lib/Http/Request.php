<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:18
 */

namespace SphereMall\MS\Lib\Http;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
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
    use RequestMethods;

    #region [Properties]
    protected $withChannel = true;
    protected $multi;
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
    public function __construct(Client $client, ServiceResource $resource, $multi = false)
    {
        $this->multi = $multi;
        $this->client = $client;
        $this->resource = $resource;
    }

    #endregion

    #region [Public methods]

    /**
     * @return $this
     */
    public function disableChannel()
    {
        $this->withChannel = false;
    }

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
        $async = $this->client->getAsync();

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

        if($this->withChannel) {
            $options['headers']['Channel-id'] = $this->client->channelId;
        }
        $options['headers']['Referer'] = ($_SERVER['HTTP_HOST'] ?? 'PHP') . ($_SERVER['REQUEST_URI'] ?? 'PHP');

        if ($body) {
            switch (strtolower($method)) {
                case 'get' :
                    $this->get($options, $body);
                    break;

                case 'put':
                    $this->put($options, $body);
                    break;

                case 'patch':
                    $this->patch($options, $body);
                    $method = 'PUT';
                    break;

                case 'post':
                    $this->post($options, $body);
                    break;

                case 'delete':
                    $this->delete($options, $body);
                    break;
            }
        }

        //Check and generate async request if needed
        $time = 0;
        if ($async) {
            return compact('method', 'url', 'options', 'time');
        }

        //Call closure if existing
        if ($this->client->beforeAPICall) {
            call_user_func($this->client->beforeAPICall, $method, $url, $options);
        }

        $time = microtime(true);

        //Return response
        try{
            $httpResponse = $client->request($method, $url, $options);
        }catch (ClientException  $e){
            $httpResponse = $e->getResponse();
        }catch (ServerException $e){
            $httpResponse = $e->getResponse();
        }

        $time = round((microtime(true) - $time), 4);
        //Set statistic history for current call
        $this->client->setCallStatistic(compact('method', 'url', 'options', 'time'));

        return new Response($httpResponse);
    }
    #endregion

    #region [Private methods]
    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function setAuthorization()
    {
        $authToken = AuthToken::getInstance($this->client);
        list($token, $userAgent) = $authToken->getTokenData();

        return [
            'headers' => [
                'Authorization' => "Bearer $token",
                'User-Agent' => $userAgent,
            ],
        ];
    }
    #endregion
}
