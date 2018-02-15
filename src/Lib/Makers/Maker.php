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
use SphereMall\MS\Lib\Collection;
use SphereMall\MS\Lib\Http\Response;

/**
 * Class Maker
 * @package SphereMall\MS\Lib\Makers
 * @property bool $asCollection Return array or collection with meta
 */
abstract class Maker
{
    #region [Properties]
    protected $asCollection = false;
    #endregion

    #region [Abstract methods]
    /**
     * @param Response $response
     *
     * @return array|Collection
     */
    abstract function makeArray(Response $response);

    /**
     * @param Response $response
     *
     * @return null|Entity
     */
    abstract function makeSingle(Response $response);
    #endregion

    #region [Public methods]
    /**
     * @param $asCollection
     */
    public function setAsCollection($asCollection)
    {
        $this->asCollection = $asCollection;
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
    #endregion
}
