<?php

namespace SphereMall\MS\Elasticsearch\Endpoints;

use Elasticsearch\Common\Exceptions\InvalidArgumentException;
use Elasticsearch\Common\Exceptions;

/**
 * Class Search
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints
 * @author   Zachary Tong <zach@elastic.co>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elastic.co
 */
class Search extends \Elasticsearch\Endpoints\Search
{
    /** @var bool */
    protected $multi = false;

    public function __construct($multi = false) {
        $this->multi = $multi;
    }

    /**
     * @return string
     */
    public function getURI()
    {
        $index = $this->index;
        $type = $this->type;

        $uri = $this->multi ? "/_msearch" : "/_search";

        if (isset($index) === true && isset($type) === true) {
            $uri = "/$index/$type".$uri;
        } elseif (isset($index) === true) {
            $uri = "/$index".$uri;
        } elseif (isset($type) === true) {
            $uri = "/_all/$type".$uri;
        }

        return $uri;
    }
}
