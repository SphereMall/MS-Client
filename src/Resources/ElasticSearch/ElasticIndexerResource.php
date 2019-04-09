<?php

namespace SphereMall\MS\Resources\ElasticSearch;

use SphereMall\MS\Entities\ElasticIndexer;
use SphereMall\MS\Exceptions\EntityNotFoundException;
use SphereMall\MS\Exceptions\MethodNotFoundException;
use SphereMall\MS\Lib\Filters\ElasticIndexer\EntitiesFilter;
use SphereMall\MS\Lib\Filters\Filter;
use SphereMall\MS\Lib\Helpers\ClassReflectionHelper;
use SphereMall\MS\Resources\Resource;

/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 30.03.2018
 * Time: 10:00
 */
class ElasticIndexerResource extends Resource
{

    /**
     * @return string
     */
    public function getURI()
    {
        return 'elasticindexer';
    }

    /**
     * @return ElasticIndexer[]
     * @throws EntityNotFoundException
     */
    public function runIndex()
    {
        $params = $this->getQueryParams();
        $response = $this->handler->handle('GET', null, 'runindex', $params);

        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getFirstErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @return ElasticIndexer[]
     * @throws EntityNotFoundException
     */
    public function reindex()
    {
        $params = $this->getQueryParams();
        $response = $this->handler->handle('GET', null, 'reindex', $params);

        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getFirstErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @return ElasticIndexer[]
     * @throws EntityNotFoundException
     */
    public function import()
    {
        $params = $this->getQueryParams();
        $response = $this->handler->handle('GET', null, 'import', $params);

        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getFirstErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @param $className
     * @param $id
     * @return ElasticIndexer[]
     * @throws EntityNotFoundException
     */
    public function importEntity($className, $id)
    {
        $type = (new ClassReflectionHelper($className))->getShortLowerCaseName();
        $type = "{$type}s";

        $params = $this->getQueryParams();
        $response = $this->handler->handle('GET', null, "import/$type/$id", $params);

        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getFirstErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @return array
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteIndex()
    {
        $response = $this->handler->handle('DELETE', null, 'delete');
        return $this->make($response, false);
    }

    /**
     * @param array $additionalParams
     * @return array
     */
    protected function getQueryParams(array $additionalParams = [])
    {
        $params = [
            'offset' => $this->offset,
            'limit'  => $this->limit,
        ];

        if ($this->filter && $this->filter instanceof EntitiesFilter) {
            $params += $this->getFilters() ?? [];
        }

        $params = array_merge($params, $additionalParams);

        return $params;
    }

    /**
     * @return array|void
     * @throws MethodNotFoundException
     */
    public function all()
    {
        throw new MethodNotFoundException("Method all() can not be use with Elasticsearch");
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
}
