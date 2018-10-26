<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 10/21/2017
 * Time: 5:26 PM
 */

namespace SphereMall\MS\Lib\Makers;

use SphereMall\MS\Entities\Entity;
use SphereMall\MS\Exceptions\EntityNotFoundException;
use SphereMall\MS\Lib\Collection;
use SphereMall\MS\Lib\Http\Meta;
use SphereMall\MS\Lib\Http\Response;
use SphereMall\MS\Lib\Mappers\Mapper;

/**
 * Class ObjectMaker
 *
 * @package SphereMall\MS\Lib\Makers
 */
class ObjectMaker extends Maker
{
    #region [Public methods]

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
     * @return null|Entity
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
     * @param array $item
     *
     * @return array
     */
    protected function getAttributes(array $item)
    {
        if (isset($item['attributes']) && is_array($item['attributes'])) {
            return $item['attributes'];
        }

        return [];
    }

    /**
     * Get relationships from array
     *
     * @param array $item
     * @param array $included
     *
     * @return array
     * @throws EntityNotFoundException
     */
    protected function getRelationships(array $item, array $included)
    {
        if (!isset($item['relationships']) || !is_array($item['relationships'])) {
            return [];
        }

        $result = [];

        foreach ($item['relationships'] as $relationKey => $relationValue) {
            foreach ($relationValue['data'] as $relationData) {
                if (!isset($included[$relationData['type']][$relationData['id']])) {
                    throw new EntityNotFoundException("Data for type[{$relationData['type']}] and id[{$relationData['id']}] was not found in includes");
                }

                $result[$relationKey][$relationData['id']] = $included[$relationData['type']][$relationData['id']];
            }
        }

        return $result;
    }

    /**
     * Prepare array of included data, we walk through ONCE
     * result example: ['brands'][706] = {attributes}
     *
     * @param array $included
     *
     * @return array
     */
    protected function getIncludedArray(array $included)
    {
        $result = [];
        foreach ($included as $include) {
            $result[$include['type']][$include['id']] = $include['attributes'];
        }

        return $result;
    }

    /**
     * @param Response $response
     *
     * @return array
     * @throws EntityNotFoundException
     */
    protected function getResultFromResponse(Response $response)
    {
        $result   = [];
        $included = $this->getIncludedArray($response->getIncluded());

        foreach ($response->getData() as $element) {
            $mapperClass = $this->getMapperClass($element['type']);
            if (is_null($mapperClass)) {
                throw new EntityNotFoundException("Entity mapper class for {$element['type']} was not found");
            }

            $result[] = $this->createObject($mapperClass, $element, $included);
        }

        return $result;
    }

    /**
     * @param $mapperClass
     * @param $element
     * @param $included
     *
     * @return mixed
     * @throws EntityNotFoundException
     */
    protected function createObject($mapperClass, $element, $included)
    {
        $item      = $this->getAttributes($element);
        $relations = $this->getRelationships($element, $included);
        /** @var Mapper $mapper */
        $mapper = new $mapperClass();

        return $mapper->createObject(array_merge($item, $relations));
    }
    #endregion
}
