<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:54
 */

namespace SphereMall\MS\Lib\Elastic\Queries;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBoolQueryInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;;

/**
 * Class MustNotQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MustNotQuery extends BasicBoolQuery implements ElasticBoolQueryInterface, ElasticBodyElement
{
    protected $queryType = 'must_not';
}
