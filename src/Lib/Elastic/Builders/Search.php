<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 05.03.19
 * Time: 23:37
 */

namespace SphereMall\MS\Lib\Elastic\Builders;


use SphereMall\MS\Lib\Elastic\Aggregations\BucketSortAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\MaxAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\TermsAggregation;
use SphereMall\MS\Lib\Elastic\Aggregations\TopHistAggregation;
use SphereMall\MS\Lib\Elastic\Interfaces\SearchInterface;
use SphereMall\MS\Lib\Elastic\Queries\MultiMatchQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustNotQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Sort\SortBuilder;
use SphereMall\MS\Lib\Elastic\Sort\SortElement;
use SphereMall\MS\Lib\Filters\FilterOperators;
use SphereMall\MS\Lib\SortParams\ElasticSearch\ByFactorValues\Algorithms\MathSum;
use SphereMall\MS\Lib\SortParams\ElasticSearch\ByFactorValues\Algorithms\MathSumWithFactor;

/**
 * Class Search
 *
 * @package SphereMall\MS\Lib\Elastic\Builders
 */
class Search implements SearchInterface
{
    const DEFAULT_SIZE = 10;

    private $body    = null;
    private $groupBy = false;
    private $params  = [];

    /**
     * Search constructor.
     *
     * @param BodyBuilder $builder
     */
    public function __construct(BodyBuilder $builder)
    {
        $this->body = [
            'filter'  => $builder->getFilter(),
            'query'   => $builder->getQuery(),
            'size'    => $builder->getLimit(),
            'from'    => $builder->getOffset(),
            '_source' => $builder->getSource(),
            'index'   => $builder->getIndexes(),
            'aggs'    => $builder->getAggregations(),
            'sort'    => $builder->getSort(),
        ];
    }

    /**
     * @return bool
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $this->params = $this->getParamsFromFilter();

        $this->query()
             ->size()
             ->from()
             ->source()
             ->indexes()
             ->aggregations()
             ->sort();

        return $this->params;
    }

    /**
     * @return bool
     */
    public function isGroup()
    {
        return $this->groupBy ? true : false;
    }

    /**
     * @param $filter
     *
     * @return array
     */
    private function getParamsFromFilter()
    {
        if (!$this->body['filter']) {
            return [];
        }

        $result  = [];
        $must    = [];
        $mustNot = [];

        $params = $this->body['filter']->getParams();

        if (isset($params['groupBy']) && $params['groupBy']) {
            $result = $this->initGroupBy($params['factorValues'] ?? []);
        }

        if (isset($params['factorValues']) && $params['factorValues'] && !$this->groupBy) {
            $sortEl[] = new SortElement("_script", "desc", [
                'type'   => "number",
                'script' => (new MathSumWithFactor($params['factorValues']))->getAlgorithm(),
            ]);

            $this->body['sort'] = (new SortBuilder($sortEl))->toArray()['sort'];
        }

        if (isset($params['entities']) && $params['entities']) {
            $result['index'] = $params['entities'];
        }

        if (isset($params['keyword'])) {
            $must[] = new MultiMatchQuery($params['keyword']['value'], $params['keyword']['fields']);
        }

        foreach ($params['params'] ?? [] as $param) {
            list($query, $operator) = $param->createFilter();

            if ($operator == FilterOperators::IN) {
                $must[] = $query;
            } else {
                $mustNot[] = $query;
            }
        }

        if ($mustNot || $must) {

            $query = new QueryBuilder();
            if ($mustNot) {
                $query->setMustNot(new MustNotQuery($mustNot));
            }
            if ($must) {
                $query->setMust(new MustQuery($must));
            }

            $result['body']['query'] = $query->toArray();
        }

        return $result;
    }

    /**
     * @param array $factorValues
     *
     * @return mixed
     */
    private function initGroupBy($factorValues = [])
    {
        $this->groupBy = true;

        $params['body']['size'] = 0;

        $size = $this->body['size'] ? $this->body['size'] : self::DEFAULT_SIZE;
        $from = $this->body['from'] ? $this->body['from'] : 0;

        $terms   = new TermsAggregation("variantsCompound", $size + $from);
        $topHist = new TopHistAggregation(['scope'], 1);
        $bucket  = new BucketSortAggregation($size, $from);

        $terms->subAggregation(new AggregationBuilder('value', $topHist))
              ->subAggregation(new AggregationBuilder('bucket', $bucket));

        if ($factorValues) {
            $max = (new MaxAggregation('_script'))->setScript((new MathSumWithFactor($factorValues))->getAlgorithm());
            $terms->subAggregation(new AggregationBuilder("factorSort", $max));
        }

        $params['body']['aggs'] = (new AggregationBuilder("variant", $terms))->toArray();

        return $params;
    }

    /**
     * @return $this
     */
    private function query()
    {
        if ($this->body['query']) {
            $this->params['body']["query"] = array_merge_recursive($this->body['query'], ($this->params['body']["query"] ?? []));
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function size()
    {
        if (!$this->groupBy && $this->body['size']) {
            $this->params['body']['size'] = $this->body['size'];
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function from()
    {
        if (!$this->groupBy && $this->body['from']) {
            $this->params['body']['from'] = $this->body['from'];
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function source()
    {
        if ($this->body['_source']) {
            $this->params['body']['_source'] = $this->body['_source'];
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function indexes()
    {
        if ($this->body['index']) {
            $this->params['index'] = $this->body['index'];
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function aggregations()
    {
        if ($this->body['aggs']) {
            $this->params['body']['aggs'] = $this->body['aggs'];
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function sort()
    {
        if ($this->body['sort']) {
            $this->params['body']['sort'] = $this->body['sort'];
        }

        return $this;
    }

}
