<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 05.03.19
 * Time: 23:37
 */

namespace SphereMall\MS\Lib\Elastic\Builders;


use SphereMall\MS\Lib\Elastic\Interfaces\SearchInterface;

class MSearch implements SearchInterface
{
    private $builders = [];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->setItem($item);
        }
    }

    private function setItem(BodyBuilder $builder)
    {
        $this->builders[] = $builder;

        return $this;
    }

    public function getParams()
    {
        $result = [];
        foreach ($this->builders as $builder) {
            /**@var \SphereMall\MS\Lib\Elastic\Builders\BodyBuilder $builder * */
            $result[] = [
                "index" => $builder->getIndexes(),
            ];

            if ($q = $builder->getQuery()) {
                $res['query'] = $q;
            }

            if ($size = $builder->getLimit()) {
                $res['size'] = $size;
            }

            if ($from = $builder->getOffset()) {
                $res['from'] = $from;
            }

            if ($source = $builder->getSource()) {
                $res['_source'] = $source;
            }

            if ($aggregations = $builder->getAggregations()) {
                $res['aggs'] = $aggregations;
            }

            if ($sort = $builder->getSort()) {
                $res
                ['sort'] = $sort;
            }

            $result[] = $res ?? [];
        }

        return [
            'body' => $result,
        ];
    }
}
