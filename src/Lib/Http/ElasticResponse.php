<?php
/**
 * Project PHP-MS-Client.
 * File: ElasticResponse.php
 * Created by Sergey Yanchevsky
 * 14.02.2018 16:00
 */

namespace SphereMall\MS\Lib\Http;

/**
 * Class ElasticResponse
 * @package SphereMall\MS\Lib\Http
 *
 * @property int $statusCode
 * @property array $headers
 * @property array $data
 * @property bool $success
 * @property string $version
 * @property array $errors
 * @property Meta $meta
 * @property array $included
 *
 * @property array $response
 */
class ElasticResponse
{
    #region [Private Properties]
    private $statusCode;
    private $headers;
    private $data;
    private $success;
    private $version;
    private $errors;
    private $meta;
    private $included;
    #endregion

    #region [Protected Properties]
    protected $response;
    #endregion

    #region [Constructor]
    /**
     * Response constructor.
     *
     * @param array $response
     *
     * @throws \Exception
     */
    public function __construct(array $response)
    {
        $this->response = $response;
        $this->statusCode = (!$response['timed_out'] ? 200 : 404);
        $this->headers    = [];

    }
    #endregion

    #region [Public Methods]
    /**
     * @return $this
     * @throws \Exception
     */
    public function search()
    {
        try {
            $this->data     = $this->mapData($this->response);
            $this->success  = !$this->response['timed_out'];
            $this->errors   = $this->response['error'] ?? null;
            $this->version  = 1;
            $this->included = $this->response['included'] ?? null;
            if (!empty($this->response['meta'])) {
                $this->meta = new Meta(...array_values($this->response['meta']));
            }
        } catch (\Exception $ex) {
            $this->success = false;
            $this->errors  = $ex->getMessage();
            throw new \Exception($ex->getMessage());
        }

        return $this;
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

    #region [Protected Methods]
    /**
     * @param array $hits
     *
     * @return array
     */
    protected function mapData(array $hits): array
    {
        $data = [];
        if (!isset($hits['hits']['hits'])) {
            return $data;
        }
        foreach ($hits['hits']['hits'] as $hit) {
            $data[] = array_merge(['id' => ($hit['_id'] ?? 0)], $hit['_source']);
        }

        return $data;
    }
    #endregion
}
