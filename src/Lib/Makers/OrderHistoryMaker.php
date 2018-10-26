<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 10/21/2017
 * Time: 5:26 PM
 */

namespace SphereMall\MS\Lib\Makers;

use SphereMall\MS\Exceptions\EntityNotFoundException;
use SphereMall\MS\Lib\Http\Response;
use SphereMall\MS\Lib\Mappers\OrdersMapper;

/**
 * Class OrderHistoryMaker
 *
 * @package SphereMall\MS\Lib\Makers
 */
class OrderHistoryMaker extends ObjectMaker
{
    #region [Protected methods]
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
            if (is_null($mapperClass = $this->getMapperClass($element))) {
                throw new EntityNotFoundException("Entity mapper class for {$element['type']} was not found");
            }
            $element  = $this->getRelations($element, $included);
            $result[] = $this->createObject($mapperClass, $element, $included);
        }

        return $result;
    }

    /**
     * @param $element
     * @param $included
     *
     * @return mixed
     */
    private function getRelations($element, $included)
    {
        foreach ($element['relationships'] as $type => $value) {
            foreach ($value['data'] as $key => $relation) {
                if (!isset($included[$type][$relation['id']])) {
                    continue;
                }
                $item = $included[$type][$relation['id']];
                if (count($item['relationships']) > 0) {
                    $item = $this->getRelations($item, $included);
                }
                unset($element['relationships'][$type]['data']);
                $element['relationships'][$type][$key] = $item;
            }
        }

        return $element;
    }

    /**
     * @param $mapperClass
     * @param $element
     * @param $included
     *
     * @return mixed
     */
    protected function createObject($mapperClass, $element, $included)
    {
        return (new $mapperClass)->createObject($element);
    }

    /**
     * @param array $included
     *
     * @return array
     */
    protected function getIncludedArray(array $included)
    {
        $result = [];
        foreach ($included as $include) {
            $result[$include['type']][$include['id']] = $include;
        }

        return $result;
    }

    /**
     * @param $type
     *
     * @return null|string
     */
    protected function getMapperClass($type)
    {
        return OrdersMapper::class;
    }

    /**
     * @param array $item
     *
     * @return array
     */
    protected function getAttributes(array $item)
    {
        return $item;
    }
    #endregion
}
