<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 08.10.2017
 * Time: 22:32
 */

namespace SphereMall\MS\Lib\Http;

/**
 * @property int $statusCode
 * @property array $headers
 * @property array $data
 * @property bool $success
 * @property string $version
 * @property array $errors
 * @property Meta $meta
 * @property array $included
 */
class Response
{
    #region [Properties]
    protected $statusCode;
    protected $headers;
    protected $data;
    protected $success;
    protected $version;
    protected $errors;
    protected $meta;
    protected $included;
    #endregion

    #region [Constructor]
    /**
     * Response constructor.
     *
     * @param \GuzzleHttp\Psr7\Response $response
     *
     * @throws \Exception
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->headers    = $response->getHeaders();

        $bodyContent = $response->getBody()->getContents();
        $contents    = json_decode($bodyContent, true);

        try {
            $this->data     = $contents['data'];
            $this->success  = $contents['success'];
            $this->errors   = $contents['error'] ?? null;
            $this->version  = $contents['ver'];
            $this->included = $contents['included'] ?? null;
            if (!empty($contents['meta'])) {
                $this->meta = new Meta(...array_values($contents['meta']));
            }
        } catch (\Exception $ex) {
            $this->success = false;
            $this->errors  = $ex->getMessage();
            throw new \Exception($ex->getMessage());
        }
    }
    #endregion

    #region [Getters]
    /**
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return json_encode($this->errors);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function getIncluded()
    {
        return $this->included;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }
    #endregion
}
