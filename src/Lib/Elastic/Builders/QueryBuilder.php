<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 26.02.2019
 * Time: 15:15
 */

namespace SphereMall\MS\Lib\Elastic\Builders;

use SphereMall\MS\Lib\Elastic\Interfaces\ElasticBodyElement;
use SphereMall\MS\Lib\Elastic\Queries\FilterQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustNotQuery;
use SphereMall\MS\Lib\Elastic\Queries\MustQuery;
use SphereMall\MS\Lib\Elastic\Queries\ShouldQuery;

class QueryBuilder implements ElasticBodyElement
{
    private $result = [];

    /**
     * @param ShouldQuery $should
     *
     * @return $this
     */
    public function setShould(ShouldQuery $should)
    {
        $this->result = array_merge($this->result, $should->toArray()['bool']);

        return $this;
    }

    /**
     * @param MustQuery $must
     *
     * @return $this
     */
    public function setMust(MustQuery $must)
    {
        $this->result = array_merge($this->result, $must->toArray()['bool']);

        return $this;
    }

    /**
     * @param MustNotQuery $mustNot
     *
     * @return $this
     */
    public function setMustNot(MustNotQuery $mustNot)
    {
        $this->result = array_merge($this->result, $mustNot->toArray()['bool']);

        return $this;
    }

    /**
     * @param FilterQuery $filter
     *
     * @return $this
     */
    public function setFilter(FilterQuery $filter)
    {
        $this->result = array_merge($this->result, $filter->toArray()['bool']);

        return $this;
    }

    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'bool' => $this->result,
        ];
    }
}
