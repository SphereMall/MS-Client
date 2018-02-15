<?php
/**
 * Project PHP-MS-Client.
 * File: ElasticMaker.php
 * Created by Sergey Yanchevsky
 * 15.02.2018 12:34
 */

namespace SphereMall\MS\Lib\Makers;

use SphereMall\MS\Exceptions\EntityNotFoundException;
use SphereMall\MS\Lib\Collection;
use SphereMall\MS\Lib\Http\ElasticResponse;
use SphereMall\MS\Lib\Http\Meta;
use SphereMall\MS\Lib\Http\Response;
use SphereMall\MS\Lib\Mappers\Mapper;

/**
 * Class ElasticMaker
 * @package SphereMall\MS\Lib\Makers
 */
class ElasticMaker extends Maker
{
    #region [Abstract methods]
    /**
     * @param Response $response
     *
     * @return array|Collection
     * @throws EntityNotFoundException
     */
    public function makeArray(Response $response)
    {
        if (!$response->getSuccess()) {
            if ($this->asCollection) {
                return new Collection([], new Meta());
            }

            return [];
        }

        $result = $this->getResultFromResponse($response);

        if ($this->asCollection) {
            $collection = new Collection($result, $response->getMeta());

            return $collection;
        }

        return $result;
    }

    /**
     * @param Response $response
     *
     * @return mixed|null|\SphereMall\MS\Entities\Entity
     * @throws EntityNotFoundException
     */
    public function makeSingle(Response $response)
    {
        if (!$response->getSuccess()) {
            return null;
        }

        $result = $this->getResultFromResponse($response);

        return $result[0] ?? null;
    }
    #endregion

    #region [Protected methods]
    /**
     * @param $type
     *
     * @return null|string
     */
    protected function getMapperClass($type)
    {
        $potentialEndpointClass = 'SphereMall\\MS\\Lib\\Mappers\\' . ucfirst($type) . 'Mapper';
        if (class_exists($potentialEndpointClass)) {
            return $potentialEndpointClass;
        }

        return null;
    }

    /**
     * @param ElasticResponse $response
     *
     * @return array
     * @throws EntityNotFoundException
     */
    protected function getResultFromResponse(ElasticResponse $response)
    {
        $result = [];

        foreach ($response->getData() as $type => $elements) {
            $mapperClass = $this->getMapperClass($type);

            if (is_null($mapperClass)) {
                throw new EntityNotFoundException("Entity mapper class for {$type} was not found");
            }

            $result = array_merge($result, $this->createObject($mapperClass, $elements));
        }

        return $result;
    }

    /**
     * @param string $mapperClass
     * @param array $elements
     *
     * @return mixed
     */
    protected function createObject(string $mapperClass, array $elements): array
    {
        $items = [];
        /**
         * @var Mapper $mapper
         */
        $mapper = new $mapperClass();
        foreach ($elements as $element) {
            $items[] = $mapper->createObject($element);
        }

        return $items;
    }
    #endregion
}
