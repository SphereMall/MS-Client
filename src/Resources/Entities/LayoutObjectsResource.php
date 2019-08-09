<?php
namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Client;
use SphereMall\MS\Exceptions\EntityNotFoundException;
use SphereMall\MS\Lib\Http\LayoutObjectsRequest;
use SphereMall\MS\Resources\Resource;

/**
 * Class LayoutObjectsResource
 * @package SphereMall\MS\Resources\Entities
 */
class LayoutObjectsResource extends Resource
{
    private $objectType;

    /**
     * LayoutObjectsResource constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->handler =  new LayoutObjectsRequest($this->client, $this);
    }


    /**
     * @return string
     */
    public function getURI()
    {
        return "layout";
    }

    /**
     * @param string $objectType
     *
     * @return LayoutObjectsResource
     */
    public function setObjectType(string $objectType) : LayoutObjectsResource
    {
        $this->objectType = $objectType;
        return $this;
    }

    /**
     * @param int $id
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \Exception
     */
    public function  getById(int $id)
    {
        $this->issetObjectType();

        $uriAppend = "/{$this->objectType}/{$id}";
        $response = $this->handler->handle('GET', false, $uriAppend);

        return $this->make($response);
    }

    /**
     * @param string $urlCode
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \Exception
     */
    public function  getByUrlCode(string $urlCode)
    {
        $this->issetObjectType();

        $uriAppend = "/{$this->objectType}/url/{$urlCode}";
        $response = $this->handler->handle('GET', false, $uriAppend);

        return $this->make($response);
    }

    /**
     * @param array $data
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     */
    public function  getObjects(array $data)
    {
        $uriAppend = "/objects";
        $response = $this->handler->handle('GET', $data, $uriAppend);

        return $this->make($response);
    }

    /**
     * @param array $data
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     */
    public function createObject($data)
    {
        $uriAppend = "objects";
        $response = $this->handler->handle('POST', $data, $uriAppend);

        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @param $data
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     */
    public function updateObject($data)
    {
        $uriAppend = "objects";

        $response = $this->handler->handle('PUT', $data, $uriAppend);
        if (!$response->getSuccess()) {
            throw new EntityNotFoundException($response->getErrorMessage());
        }

        return $this->make($response);
    }

    /**
     * @throws \Exception
     */
    public function issetObjectType()
    {
        if (is_null($this->objectType)) {
            throw new \Exception("Need to set the value parameter objectType");
        }
    }
}
