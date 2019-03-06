<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:54
 */

namespace SphereMall\MS\Lib\Elastic\Queries;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBoolQueryInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElementInterface;;

/**
 * Class MustNotQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MustNotQuery extends BasicBoolQuery implements ElasticBoolQueryInterface, ElasticBodyElementInterface
{
    protected $queryType = 'must_not';
}
