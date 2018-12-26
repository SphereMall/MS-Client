<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 10/29/2017
 * Time: 5:15 PM
 */

namespace SphereMall\MS\Lib\Shop;

use InvalidArgumentException;
use SphereMall\MS\Client;
use SphereMall\MS\Entities\Address;
use SphereMall\MS\Entities\Order;
use SphereMall\MS\Entities\User;
use SphereMall\MS\Exceptions\EntityNotFoundException;

/**
 * Class Basket
 *
 * @package SphereMall\MS\Lib\Shop
 */
class Basket extends OrderFinalized
{
    #region [Properties]
    private $updateParams = [];
    private $version;
    #endregion

    #region [Constructor]
    /**
     * Basket constructor.
     *
     * @param Client   $client
     * @param int|null $id
     *
     * @param string   $version
     *
     * @throws EntityNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(Client $client, int $id = null, string $version = 'v2')
    {
        parent::__construct($client);
        $this->version = $version;
        if (!is_null($id)) {
            $this->id = $id;
            $this->getBasket($this->id);
        }
    }
    #endregion

    #region [Public methods]
    /**
     * @param array $params
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(array $params)
    {
        if (is_null($this->getId())) {
            $this->createBasket();
        }

        $this->callResourceAction(function ($params) {
            return $this->client->basketResource($this->version)
                                ->create($params);
        }, $params);
    }

    /**
     * @param array $params
     */
    public function remove(array $params)
    {
        if (is_null($this->getId())) {
            throw new InvalidArgumentException("Can not delete items. Shop is not created.");
        }

        $this->callResourceAction(function ($params) {
            return $this->client->basketResource($this->version)
                                ->removeItems($params);
        }, $params);
    }

    /**
     * @param array $params
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(array $params = [])
    {
        if (is_null($this->getId())) {
            $this->createBasket();
        }

        $params = array_merge($params, $this->updateParams);

        $this->callResourceAction(function ($params) {
            return $this->client->basketResource($this->version)
                                ->update($this->getId(), $params);
        }, $params);

        $this->updateParams = [];
    }
    #endregion

    #region [Setters]
    /**
     * @param $paymentMethod
     *
     * @return $this
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->updateParams['paymentMethodId'] = $paymentMethod;

        return $this;
    }

    /**
     * @param Delivery $delivery
     *
     * @return $this
     */
    public function setDelivery(Delivery $delivery)
    {
        if (!$delivery->id) {
            throw new InvalidArgumentException("Can not set delivery. Delivery id is empty.");
        }

        $this->updateParams['deliveryProviderId'] = $delivery->id;
        $this->updateParams['deliveryCost']       = $delivery->getCost();

        return $this;
    }

    /**
     * @param Address $address
     *
     * @return $this
     * @throws EntityNotFoundException
     */
    public function setShippingAddress(Address $address)
    {
        $this->setAddress($address, 'shippingAddress');

        return $this;
    }

    /**
     * @param Address $address
     *
     * @return $this
     * @throws EntityNotFoundException
     */
    public function setBillingAddress(Address $address)
    {
        $this->setAddress($address, 'billingAddress');

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        if (!$user->id) {
            throw new InvalidArgumentException("Can set user. User id is empty.");
        }

        $this->updateParams['userId'] = $user->id;

        return $this;
    }
    #endregion

    #region [Protected methods]
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function createBasket()
    {
        /**@var Order $order */
        $order    = $this->client->basketResource($this->version)
                                 ->new([]);
        $this->id = $order->id;
    }

    /**
     * @param int $id
     *
     * @throws EntityNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getBasket(int $id)
    {
        /** @var Order $order */
        $order = $this->client->basketResource($this->version)
                              ->get($id, ['recalculate' => true]);
        if (is_null($order)) {
            throw new EntityNotFoundException("Can not found basket with id: $id");
        }
        $this->id = (int)$order->id;
        $this->setProperties($order);
    }

    /**
     * @param Address $address
     * @param         $addressKey
     *
     * @throws EntityNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function setAddress(Address $address, $addressKey)
    {
        if (!$address->id) {
            $addressResource = $this->client
                ->addresses()
                ->create($address->asArray());

            if ($addressResource) {
                $address = $addressResource;
            }
        }

        $this->updateParams["{$addressKey}Id"] = $address->id;
    }

    /**
     * @param callable $action
     * @param array    $params
     */
    protected function callResourceAction(callable $action, array $params)
    {
        $params['basketId'] = $this->getId();

        if (isset($params['products'])) {
            $params['products'] = json_encode($params['products']);
        }

        $order = call_user_func($action, $params);

        $this->setProperties($order);
    }
    #endregion
}
