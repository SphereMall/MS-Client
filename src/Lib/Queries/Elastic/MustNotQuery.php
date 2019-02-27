<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:54
 */

namespace SphereMall\MS\Lib\Queries\Elastic;

use SphereMall\MS\Lib\Queries\Interfaces\ElasticBoolQueryInterface;

/**
 * Class MustNotQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MustNotQuery extends BasicBoolQuery implements ElasticBoolQueryInterface
{
    protected $queryType = 'must_not';
}
