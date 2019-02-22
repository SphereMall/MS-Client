<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 20.11.18
 * Time: 16:46
 */

namespace SphereMall\MS\Lib\Queries\Interfaces;

/**
 * Interface ElasticFilterInterface
 *
 * @package SphereMall\MS\Lib\Filters\Interfaces
 */
interface ElasticBoolQueryInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}
