<?php
/**
 * Created by PhpStorm.
 * User: DmitriyVorobey
 * Date: 19.02.2018
 * Time: 10:07
 */

namespace SphereMall\MS\Resources\ElasticSearch;

use SphereMall\MS\Client;
use SphereMall\MS\Exceptions\MethodNotFoundException;
use SphereMall\MS\Lib\Filters\ElasticSearch\SearchFilter;
use SphereMall\MS\Lib\Http\ElasticSearchRequest;
use SphereMall\MS\Lib\Http\ElasticSearchResponse;
use SphereMall\MS\Lib\Makers\ElasticSearchAutoCompleteMaker;
use SphereMall\MS\Lib\Makers\ElasticSearchFacetedMaker;
use SphereMall\MS\Lib\Makers\Maker;
use SphereMall\MS\Resources\Resource;

/**
 * Class ElasticSearchResource
 * @package SphereMall\MS\Resources\ElasticSearch
 *
 * @property SearchFilter $filter
 */
class ElasticSearchResource extends Resource
{
    #region [Override methods]
    /**
     * @return string
     */
    public function getURI()
    {
        return 'elasticsearch';
    }

    /**
     * ElasticSearchResource constructor.
     * @param Client $client
     * @param null   $version
     * @param null   $handler
     * @param null   $maker
     */
    public function __construct(Client $client, $version = null, $handler = null, $maker = null)
    {
        parent::__construct($client, $version, $handler, $maker);
        $this->handler = $handler ?? new ElasticSearchRequest($this->client, $this);
    }

    /**
     * @return array|int|null|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function facets()
    {
        $this->maker = new ElasticSearchFacetedMaker();
        $params      = $this->getQueryParams($this->filter ? $this->filter->getFacetedFilters() : []);

        return $this->make($this->getResponse($params));
    }

    /**
     * @return array|int|null|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all()
    {
        $params = $this->getQueryParams($this->filter && method_exists( $this->filter, 'getSearchFilters') ? $this->filter->getSearchFilters() : []);

        return $this->make($this->getResponse($params));
    }

    /**
     * @param array $langs
     * @return array|int|null|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function autoComplete(array $langs = [])
    {
        $this->maker = new ElasticSearchAutoCompleteMaker($langs);
        $params = $this->getQueryParams($this->filter ? $this->filter->getSearchFilters() : []);

        return $this->make($this->getResponse($params));
    }

    /**
     * @param array $additionalParams
     *
     * @return array
     */
    protected function getQueryParams(array $additionalParams = [])
    {
        $params                 = parent::getQueryParams();
        $params['body']['from'] = $params['offset'];
        $params['body']['size'] = $params['limit'];

        unset($params['offset']);
        unset($params['limit']);

        $decodeWhere = [];
        if(stristr($params['where'], "\n") && $multiParams = explode("\n", $params['where'])){
            foreach ($multiParams  AS $item){
                if($item){
                    $decodeWhere['body'][] = json_decode($item, true);
                }
            }
        }else{
            $decodeWhere = json_decode($params['where'], true);
        };

        $where = !empty($additionalParams) ? $additionalParams : $decodeWhere;
        if (empty($where)) {
            return $params;
        }

        if (isset($where['body'])) {
            $params['body'] = array_merge($params['body'], $where['body']);
            unset($where['body']);
        }
        foreach ($where as $key => $value) {
            $params[$key] = $value;
        }

        unset($params['where']);

        if (isset($params['sort']) && $params['sort']) {
            $params['body']['sort'] = $params['sort'];
            unset($params['sort']);
        }

        return $params;
    }

    /**
     * @param \GuzzleHttp\Promise\Promise|\SphereMall\MS\Lib\Http\Response $response
     * @param bool                                                         $makeArray
     * @param Maker|null                                                   $maker
     * @return array|int|null|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     */
    protected function make($response, $makeArray = true, Maker $maker = null)
    {
        if (is_null($maker)) {
            $maker = $this->maker;
        }

        if ($response instanceof ElasticSearchResponse) {
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
     * @return int|void
     * @throws MethodNotFoundException
     */
    public function count()
    {
        throw new MethodNotFoundException("Method count() can not be use with Elasticsearch");
    }

    /**
     * @param int $id
     * @return array|\SphereMall\MS\Entities\Entity|void
     * @throws MethodNotFoundException
     */
    public function get(int $id)
    {
        throw new MethodNotFoundException("Method get() can not be use with Elasticsearch");
    }

    /**
     * @param $id
     * @param $data
     * @return \SphereMall\MS\Entities\Entity|void
     * @throws MethodNotFoundException
     */
    public function update($id, $data)
    {
        throw new MethodNotFoundException("Method update() can not be use with Elasticsearch");
    }

    /**
     * @param $data
     * @return \SphereMall\MS\Entities\Entity|void
     * @throws MethodNotFoundException
     */
    public function create($data)
    {
        throw new MethodNotFoundException("Method create() can not be use with Elasticsearch");
    }

    /**
     * @param $id
     * @return bool|void
     * @throws MethodNotFoundException
     */
    public function delete($id)
    {
        throw new MethodNotFoundException("Method delete() can not be use with Elasticsearch");
    }

    #endregion

    #region [privates methods]
    /**
     * @param $params
     * @return \GuzzleHttp\Promise\PromiseInterface|ElasticSearchResponse|\SphereMall\MS\Lib\Http\Response
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getResponse($params)
    {
        return $this->handler->handle('GET', false, false, $params);
    }

    #endregion

}
