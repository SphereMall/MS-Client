<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 11/5/2017
 * Time: 12:32 PM
 */

namespace SphereMall\MS\Lib\Http;

use GuzzleHttp\Exception\TransferException;
use SphereMall\MS\Client;

/**
 * Class AuthToken
 * @package SphereMall\MS\Lib\Http
 */
class AuthToken
{
    /**
     * @var Client
     */
    private $client;

    private static $instances;
    private $token = null;

    const GUEST_COOKIE_NAME = "MS_GUEST_COOKIE";

    /**
     * AuthToken constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Client $client
     * @return AuthToken
     */
    public static function getInstance(Client $client)
    {
        if (!isset(static::$instances[$client->getClientId()])) {
            static::$instances[$client->getClientId()] = new static($client);
        }

        return static::$instances[$client->getClientId()];
    }

    /**
     * @return array|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function getTokenData()
    {
        $userAgent = ($_SERVER['SERVER_NAME'] ?? 'SphereMall') . '_AGENT_' . Client::$userAgent;

        if (isset($_COOKIE[AuthToken::GUEST_COOKIE_NAME])) {
            $this->token = $_COOKIE[AuthToken::GUEST_COOKIE_NAME];
        }

        if ($this->token) {
            return [$this->token, $userAgent];
        }

        $options['content-type'] = 'application/x-www-form-urlencoded';
        $options['form_params']['client_id'] = $this->client->getClientId();
        $options['form_params']['client_secret'] = $this->client->getSecretKey();
        $options['headers']['User-Agent'] = $userAgent;


        $url = $this->client->getGatewayUrl() . '/' . $this->client->getVersion() . '/' . 'auth/token';

        try {
            $client = new \GuzzleHttp\Client();


            //Check and generate async request if needed
            $time = microtime(true);
            $response = $client->request('POST', $url, $options);

            $time = round((microtime(true) - $time), 4);
            //Set statistic history for current call
            $this->client->setCallStatistic(['method'  => "POST",
                                             'url'     => $url,
                                             'options' => $options,
                                             'time'    => $time,
            ]);

            $response = new Response($response);
            if ($response->getSuccess()) {
                $this->token = $response->getData()[0]['accessToken'] ?? false;
                $expiries = $response->getData()[0]['expires_in'];
                $isGuest = $response->getData()[0]['isGuest'] ?? true;
                if ($isGuest) {
                    try {
                        setcookie(AuthToken::GUEST_COOKIE_NAME, $this->token, $expiries, '/', '',
                            !empty($_SERVER['HTTPS']), true);
                    } catch (\Exception $ex) {
                        //TODO: Can not set cookies with unit tests
                    }
                }
            }

        } catch (TransferException $e) {
            return false;
        }

        return [$this->token, $userAgent];
    }
}
