<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 27.02.19
 * Time: 10:40
 */

namespace SphereMall\MS\Lib\Elastic\Builders;


use SphereMall\MS\Lib\Elastic\Sort\SortBuilder;

/**
 * Class BodyBuilder
 *
 * @package SphereMall\MS\Lib\Elastic\Builders
 *
 * @method getQuery()
 * @method getAggregations()
 * @method getSort()
 * @method getSource()
 * @method getIndexes()
 * @method getLimit()
 * @method getOffset()
 * @method getFilter()
 */
class BodyBuilder
{
    private $query       = null;
    private $aggregation = [];
    private $sort        = null;
    private $source      = null;
    private $indexes     = null;
    private $limit       = null;
    private $offset      = null;
    private $filter      = null;

    /**
     * @param $name
     * @param $arguments
     *
     * @return bool
     */
    public function __call($name, $arguments)
    {
        if (stripos($name, 'get') === false) {
            return false;
        }

        $propName = strtolower(str_replace("get", "", $name));

        if (!isset($this->{$propName})) {
            return false;
        }

        return $this->{$propName};
    }

    /**
     * @param QueryBuilder $query
     *
     * @return $this
     */
    public function query(QueryBuilder $query)
    {
        $this->query = $query->toArray();

        return $this;
    }

    /**
     * @param AggregationBuilder $aggregation
     *
     * @return $this
     */
    public function aggregations(AggregationBuilder $aggregation)
    {
        $this->aggregation[] = $aggregation->toArray();

        return $this;
    }

    /**
     * @param SortBuilder $sort
     *
     * @return $this
     */
    public function sort(SortBuilder $sort)
    {
        $this->sort = $sort->toArray();

        return $this;
    }

    /**
     * @param array $source
     *
     * @return $this
     */
    public function source(array $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param array $indexes
     *
     * @return $this
     */
    public function indexes(array $indexes)
    {
        $this->indexes = implode(',', $indexes);

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param int $offset
     *
     * @return $this
     */
    public function offset(int $offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function filter(FilterBuilder $filter)
    {
        $this->filter = $filter;

        return $this;
    }

}
