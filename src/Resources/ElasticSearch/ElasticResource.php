<?php
/**
 * Created by PhpStorm.
 * User: Davidych
 * Date: 19.11.18
 * Time: 17:10
 */

namespace SphereMall\MS\Resources\ElasticSearch;

use SphereMall\MS\Client;
use SphereMall\MS\Lib\Elastic\Builders\BodyBuilder;
use SphereMall\MS\Lib\Elastic\Builders\FilterBuilder;
use SphereMall\MS\Lib\Elastic\Builders\MSearch;
use SphereMall\MS\Lib\Elastic\Builders\Search;
use SphereMall\MS\Lib\Makers\ElasticSearchMaker;
use SphereMall\MS\Resources\Resource;

/**
 * Class ElasticResource
 *
 * @package SphereMall\MS\Resources\ElasticSearch
 */
class ElasticResource extends Resource
{
    private $search = null;

    public function __construct(Client $client, $version = null, $handler = null, $maker = null)
    {
        parent::__construct($client, $version, $handler, $maker);
        $this->handler = $handler ?? null;
    }

    public function getURI()
    {
        return 'elasticsearch';
    }

    /**
     * @param BodyBuilder $builder
     *
     * @return $this
     */
    public function search(BodyBuilder $builder)
    {
        $this->search = new Search($builder);

        return $this;
    }

    /**
     * @param array $builders
     *
     * @return $this
     */
    public function msearch(array $builders)
    {
        $this->search = new MSearch($builders);

        return $this;
    }

    /**
     * @param array|\SphereMall\MS\Lib\Filters\Filter|\SphereMall\MS\Lib\Specifications\Basic\FilterSpecification $filter
     *
     * @return $this|Resource
     * @throws \Exception
     */
    public function filter($filter)
    {
        if (!is_a($filter, FilterBuilder::class)) {
            throw new \Exception ("Filter must be extend class 'FilterBuilder'");
        }

        $this->filter = $filter;

        return $this;
    }


    public function facets()
    {
        $handler = new \SphereMall\MS\Lib\Http\Request($this->client, $this);
        $response = $handler->handle('GET', $this->filter->getConfigs(), 'filter', $this->filter->getQuery());

        return $this->make($response);
    }


    public function all()
    {
        $handler  = new \SphereMall\MS\Lib\Http\ElasticSearch\Request($this->client, $this);
        $response = $handler->handle('GET', false, false, [$this->search]);

        return $this->make($response, true, new ElasticSearchMaker());
    }

}
