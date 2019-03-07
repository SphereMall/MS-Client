<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 07.03.19
 * Time: 10:10
 */

namespace SphereMall\MS\Lib\Elastic\Interfaces;

/**
 * Interface ElasticConfigElementInterface
 *
 * @package SphereMall\MS\Lib\Elastic\Interfaces
 */
interface ElasticConfigElementInterface
{
    /**
     * @return array
     */
    public function getElements(): array;
}
