<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 22.02.19
 * Time: 18:46
 */

namespace SphereMall\MS\Lib\Elastic\Queries;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBoolQueryInterface;
use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;

/**
 * Class MustQuery
 *
 * @package SphereMall\MS\Lib\Queries\Elastic
 */
class MustQuery extends BasicBoolQuery implements ElasticBoolQueryInterface, ElasticBodyElement
{
    protected $queryType = 'must';
}
