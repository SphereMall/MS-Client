<?php
/**
 * Created by PhpStorm.
 * User: Serhey Yanchevsky
 * Date: 13.02.2018
 * Time: 17:29
 */

namespace SphereMall\MS\Resources\Elasticsearch;

use Exception;
use SphereMall\MS\Client;
use SphereMall\MS\Exceptions\MethodNotFoundException;
use SphereMall\MS\Lib\Http\ElasticRequest;
use SphereMall\MS\Lib\Http\ElasticResponse;
use SphereMall\MS\Lib\Http\Response;
use SphereMall\MS\Lib\Makers\ElasticMaker;
use SphereMall\MS\Lib\Makers\Maker;


/**
 * Class ElasticsearchResource
 * @package SphereMall\MS\Resources\Grapher
 *
 * @property ElasticRequest $handler
 */
class ElasticsearchResource extends ElasticResource
{
    #region [Override methods]
    public function getURI()
    {
        return "elasticsearch";
    }
    #endregion

    #region [Constructor]
    /**
     * BaseService constructor.
     *
     * @param Client $client
     * @param null $version
     * @param null $handler
     * @param null $maker
     */
    public function __construct(Client $client, $version = null, $handler = null, $maker = null)
    {
        parent::__construct($client, $version, $handler, $maker);

        $this->handler = new ElasticRequest($this->client, $this);
        $this->maker   = new ElasticMaker();
    }
    #endregion

    #region [Override methods]
    /**
     * @param bool $mock
     *
     * @return array|int|null|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(bool $mock = false)
    {
        $response = $this->handler->handle('search', $this->getQueryParams(), $mock);

        return $this->make($response, true);
    }

    /**
     * @throws MethodNotFoundException
     */
    public function facets()
    {
        throw new MethodNotFoundException("Method facets() can not be use with Elasticsearch");
    }

    /**
     * @return int|void
     * @throws MethodNotFoundException
     */
    public function count()
    {
        throw new MethodNotFoundException("Method count() can not be use with Elasticsearch");
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     */
    public function get(int $id)
    {
        throw new MethodNotFoundException("Method get() can not be use with Elasticsearch");
    }

    /**
     * @param $id
     * @param $data
     *
     * @throws Exception
     */
    public function update($id, $data)
    {
        throw new MethodNotFoundException("Method update() can not be use with Elasticsearch");
    }

    /**
     * @param $data
     *
     * @throws Exception
     */
    public function create($data)
    {
        throw new MethodNotFoundException("Method create() can not be use with Elasticsearch");
    }

    /**
     * @param $id
     *
     * @return bool|void
     * @throws Exception
     */
    public function delete($id)
    {
        throw new MethodNotFoundException("Method delete() can not be use with Elasticsearch");
    }

    /**
     *
     * @return bool|void
     * @throws Exception
     */
    public function all()
    {
        throw new MethodNotFoundException("Method all() can not be use with Elasticsearch");
    }
    #endregion

    #region [Protected methods]
    /**
     * @param \GuzzleHttp\Promise\Promise|Response|array|ElasticResponse $response
     * @param bool $makeArray
     * @param Maker|null $maker
     *
     * @return array|int|null|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     */
    protected function make($response, $makeArray = true, Maker $maker = null)
    {
        if (is_null($maker)) {
            $maker = $this->maker;
        }

        $maker->setAsCollection($this->meta);

        if ($response instanceof ElasticResponse) {
            if ($this->client->afterAPICall) {
                call_user_func($this->client->afterAPICall, $response);
            }

            if ($makeArray) {
                return $maker->makeArray($response);
            }

            return $maker->makeSingle($response);
        }

        return ['response' => $response, 'maker' => $maker, 'makeArray' => $makeArray];
    }

    /**
     * @return array
     */
    protected function getQueryParams(): array
    {
        $params = [
            'offset' => $this->offset,
            'limit'  => $this->limit,
        ];

        if ($this->ids) {
            $params['ids'] = implode(',', $this->ids);
        }

        if ($this->fields) {
            $params['fields'] = implode(',', $this->fields);
        }

        if ($this->filter) {
            $params['where'] = (string)$this->filter;
        }

        if ($this->in) {
            $params['in'] = json_encode($this->in);
        }

        if ($this->sort) {
            $params['sort'] = implode(',', $this->sort);
        }

        return $params;
    }
    #endregion
}
