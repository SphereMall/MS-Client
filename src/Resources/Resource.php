<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:07
 */

namespace SphereMall\MS\Resources;

use GuzzleHttp\Promise\Promise;
use SphereMall\MS\Client;
use SphereMall\MS\Entities\Entity;
use SphereMall\MS\Exceptions\EntityNotFoundException;
use SphereMall\MS\Lib\Collection;
use SphereMall\MS\Lib\FieldsParams\FieldsParams;
use SphereMall\MS\Lib\Filters\ElasticSearch\FullTextFilter;
use SphereMall\MS\Lib\Filters\Filter;
use SphereMall\MS\Lib\Makers\CountMaker;
use SphereMall\MS\Lib\Makers\Maker;
use SphereMall\MS\Lib\Makers\ObjectMaker;
use SphereMall\MS\Lib\Http\Request;
use SphereMall\MS\Lib\Http\Response;
use SphereMall\MS\Lib\SortParams\ElasticSearch\FieldSortParams;
use SphereMall\MS\Lib\SortParams\SortParams;
use SphereMall\MS\Lib\Specifications\Basic\FilterSpecification;
use SphereMall\MS\Resources\ElasticSearch\ElasticSearchResource;

/**
 * @property Client $client
 * @property string $version
 * @property Request $handler
 * @property Maker $maker
 * @property int $offset
 * @property int $limit
 * @property array $ids
 * @property array $fields
 * @property Filter $filter
 * @property array $in
 * @property array $sort
 */
abstract class Resource
{
    #region [Properties]
    protected $client;
    protected $version;
    protected $handler;
    protected $maker;
    protected $offset = 0;
    protected $limit  = 10;
    protected $ids    = [];
    protected $fields = [];
    protected $filter;
    protected $in     = [];
    protected $sort   = [];
    protected $meta   = false;
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
        $this->client  = $client;
        $this->version = $version ?? $client->getVersion();

        $this->handler = $handler ?? new Request($this->client, $this);

        $this->maker = $maker ?? new ObjectMaker();
    }
    #endregion

    #region [Abstract methods]
    abstract function getURI();
    #endregion

    #region [Query methods]
    /**
     * Set a limit on the number of resource and offset for skipping the number of resource
     *
     * @param $offset
     * @param $limit
     *
     * @return $this
     */
    public function limit($limit = 10, $offset = 0)
    {
        $this->limit  = $limit;
        $this->offset = $offset;

        return $this;
    }

    /**
     * Get the resource limit
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get the resource offset
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set list of ids for selecting list of resources
     *
     * @param array $ids
     *
     * @return $this
     */
    public function ids(array $ids)
    {
        $this->ids = $ids;

        return $this;
    }

    /**
     * Get list of ids for selecting list of resources
     * @return array
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * Set list of fields for selecting the resource
     *
     * @param $fields
     *
     * @return $this
     */
    public function fields($fields)
    {
        $this->fields = $fields instanceof FieldsParams ? $fields->getFields() : $fields;

        return $this;
    }

    /**
     * Get list of fields for selecting the resources
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set filter to the resource selecting
     *
     * @param array|Filter|FilterSpecification $filter
     *
     * @return $this
     */
    public function filter($filter)
    {
        if (is_array($filter)) {
            $filter = new Filter($filter);
        }

        if ($filter instanceof FilterSpecification) {
            $filter = new Filter($filter->asFilter());
        }

        $this->filter = $filter;

        return $this;
    }

    /**
     * Set filters to the resource selecting
     *
     * @param array $filters
     * @return $this
     */
    public function filters(array $filters)
    {

        /** @var MultiFullTextFilter $filter */
        foreach ($filters AS $filter) {
            $this->filters[] = $filter;
        }

        return $this;
    }

    /**
     * Get current filter
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param $field
     * @param $values
     *
     * @return $this
     */
    public function in($field, $values)
    {
        $this->in = [$field => $values];

        return $this;
    }

    /**
     * Set field for sorting
     *
     * @param $field
     *
     * @return $this
     */
    public function sort($field)
    {
        if($field instanceof SortParams){
            $this->sort = array_merge($this->sort, $field->getParams());
        } else {
            $this->sort[] = $field;
        }

        return $this;
    }

    /**
     * Get fields for sorting
     * @return array
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Get resource version
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return $this
     */
    public function withMeta()
    {
        $this->meta = true;

        return $this;
    }
    #endregion

    #region [CRUD]
    /**
     * Get entity by id
     *
     * @param int $id
     *
     * @return array|Entity
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(int $id)
    {
        $params = [];

        if ($this->fields) {
            $params['fields'] = implode(',', $this->fields);
        }

        $response = $this->handler->handle('GET', false, $id, $params);

        return $this->make($response, false);
    }

    /**
     * Get list of entities
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all()
    {
        $params = $this->getQueryParams();

        $response = $this->handler->handle('GET', false, 'by', $params);

        return $this->make($response);
    }

    /**
     * Get first entity - limit = 1
     * @return Entity|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function first()
    {
        $this->limit(1, 0);
        $params   = $this->getQueryParams();
        $response = $this->handler->handle('GET', false, 'by', $params);

        return $this->make($response, false);
    }

    /**
     * @return int
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function count()
    {
        $params = $this->getQueryParams();

        $response = $this->handler->handle('GET', false, 'count', $params);

        return $this->make($response, false, new CountMaker());
    }

    /**
     * @param $data
     *
     * @return Entity
     * @throws EntityNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($data)
    {
        $response = $this->handler->handle('POST', $data);
        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getErrorMessage());
        }

        return $this->make($response, false);
    }

    /**
     * @param array $data
     *
     * @return Collection
     * @throws EntityNotFoundException
     */
    public function createList(array $data)
    {
        $response = $this->handler->handle('POST', $data);
        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @param $id
     * @param $data
     *
     * @return Entity
     * @throws EntityNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($id, $data)
    {
        $response = $this->handler->handle('PUT', $data, $id);
        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getErrorMessage());
        }

        return $this->make($response, false);
    }

    /**
     * @param array $data
     * @return Collection
     * @throws EntityNotFoundException
     */
    public function updateList(array $data)
    {
        $response = $this->handler->handle('PATCH', $data);
        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @param $id
     *
     * @return bool
     * @throws EntityNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        $response = $this->handler->handle('DELETE', false, $id);
        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getErrorMessage());
        }

        return $response->getSuccess();
    }

    /**
     * Delete list should be added
     */
    #endregion

    #region [Protected methods]
    /**
     * @param Promise|Response $response
     * @param bool $makeArray
     * @param Maker|null $maker
     *
     * @return array|Collection|Entity|int
     */
    protected function make($response, $makeArray = true, Maker $maker = null)
    {
        if (is_null($maker)) {
            $maker = $this->maker;
        }

        $maker->setAsCollection($this->meta);

        if ($response instanceof Response) {
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
     * @param array $additionalParams
     *
     * @return array
     */
    protected function getQueryParams(array $additionalParams = [])
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
            if (method_exists($this->filter, 'setFields') && sizeof($this->fields) > 0) {
                $this->filter->setFields($this->fields);
                unset($params['fields']);
            }
            $params['where'] = (string)$this->filter;
        } elseif (!empty($this->filters)) {
            foreach ($this->filters AS $filter) {
                if (method_exists($filter, 'setFields') && sizeof($filter) > 0) {
                    $filter->setFields($filter->fields);
                    unset($params['fields']);
                }
                $params['where'] .= (string)$filter;
            }
        }

        if ($this->in) {
            $params['in'] = json_encode($this->in);
        }

        if ($this->sort) {
            $params['sort'] = $this instanceof ElasticSearchResource ? $this->sort : implode(',', $this->sort);
        }

        return $params;
    }
    #endregion
}
