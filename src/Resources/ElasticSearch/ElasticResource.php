<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 19.11.18
 * Time: 17:10
 */

namespace SphereMall\MS\Resources\ElasticSearch;

use SphereMall\MS\Lib\Filters\Elastic\Builders\EntitiesFilterBuilder;
use SphereMall\MS\Lib\Filters\Elastic\Builders\GroupByFilterBuilder;
use SphereMall\MS\Lib\Filters\Elastic\Builders\KeywordFilterBuilder;
use SphereMall\MS\Lib\Filters\Elastic\Builders\Params\QueryFactory;
use SphereMall\MS\Lib\Filters\Elastic\Builders\ParamsFilterBuilder;
use SphereMall\MS\Lib\Filters\Elastic\Config\ConfigBuilder;
use SphereMall\MS\Lib\Filters\Interfaces\ElasticFilterInterface;
use SphereMall\MS\Lib\Http\ElasticSearchRequest;
use SphereMall\MS\Lib\Makers\ElasticSearchGroupByMaker;
use SphereMall\MS\Lib\Makers\ElasticSearchMaker;
use SphereMall\MS\Lib\Makers\FacetsMaker;
use SphereMall\MS\Lib\SortParams\ElasticSearch\ByFactorValues\Algorithms\BasicAlgorithm;
use SphereMall\MS\Resources\Resource;

/**
 * Class ElasticResource
 *
 * @package SphereMall\MS\Resources\ElasticSearch
 */
class ElasticResource extends Resource
{

}
