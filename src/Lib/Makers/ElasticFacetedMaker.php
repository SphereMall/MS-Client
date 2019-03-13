<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 13.03.19
 * Time: 16:51
 */

namespace SphereMall\MS\Lib\Makers;


use SphereMall\MS\Exceptions\EntityNotFoundException;
use SphereMall\MS\Lib\Http\Response;

/**
 * Class ElasticFacetedMaker
 *
 * @package SphereMall\MS\Lib\Makers
 */
class ElasticFacetedMaker extends ObjectMaker
{
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

            $result[$element['type']][] = $this->createObject($mapperClass, $element, $included);
        }

        return $result;
    }
}
