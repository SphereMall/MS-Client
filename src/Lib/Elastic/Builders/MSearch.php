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
        // TODO: Implement getParams() method.
    }
}
