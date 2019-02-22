<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:46
 */

namespace SphereMall\MS\Lib\Queries\Elastic;


use SphereMall\MS\Lib\Queries\Interfaces\ElasticBoolQueryInterface;

/**
 * Class MustQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MustQuery extends BasicBoolQuery implements ElasticBoolQueryInterface
{
    protected $queryType = 'must';
}
