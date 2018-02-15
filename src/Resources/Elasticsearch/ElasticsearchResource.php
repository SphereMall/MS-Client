<?php
/**
 * Created by PhpStorm.
 * User: Serhey Yanchevsky
 * Date: 13.02.2018
 * Time: 17:29
 */

namespace SphereMall\MS\Resources\Elasticsearch;

use Exception;
use SphereMall\MS\Exceptions\MethodNotFoundException;
use SphereMall\MS\Lib\Http\ElasticRequest;
use SphereMall\MS\Lib\Makers\ElasticMaker;

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

    #region [Override methods]
    /**
     *
     * @return array|int|null|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search()
    {
        $this->handler = new ElasticRequest($this->client, $this);
        $this->maker   = new ElasticMaker();

        $response = $this->handler->handle('search', false, false, $this->getQueryParams());

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
}
