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
use SphereMall\MS\Lib\Elastic\Builders\MSearch;
use SphereMall\MS\Lib\Elastic\Builders\Search;
use SphereMall\MS\Lib\Http\ElasticSearch\Request;
use SphereMall\MS\Lib\Http\ElasticSearch\Response;
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
        $this->handler = $handler ?? new Request($this->client, $this);
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


    public function all()
    {
        $this->maker = new ElasticSearchMaker();
        return $this->make($this->getResponse());
    }

    /**
     * @param $params
     *
     * @return \GuzzleHttp\Promise\PromiseInterface|Response|\SphereMall\MS\Lib\Http\Response
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getResponse()
    {
        return $this->handler->handle('GET', false, false, [$this->search]);
    }

}
