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
class ElasticResponse extends Response
{
    #region [constants]
    const REPLACE_PREFIX      = 'sm-';
    const REPLACE_SUFFIX_TEST = '-test';
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
            $this->included = [];
            $this->meta     = null;
        } catch (\Exception $ex) {
            $this->success = false;
            $this->errors  = $ex->getMessage();
            throw new \Exception($ex->getMessage());
        }

        return $this;
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
            $scope = $hit['_source']['scope'] ?? '';
            if (!$scope) {
                continue;
            }
            if (is_string($scope)) {
                $scope = json_decode($scope, true);
            }
            $scope['type'] = $this->getIndexName($hit['_index']);
            $data[] = $scope;
        }

        return $data;
    }

    /**
     * @param string $index
     *
     * @return string
     */
    protected function getIndexName(string $index): string
    {
        if (!$index) {
            return 'nonIndex';
        }

        return str_replace([self::REPLACE_PREFIX, self::REPLACE_SUFFIX_TEST], '', $index);
    }
    #endregion
}