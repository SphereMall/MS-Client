<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Shop;

use SphereMall\MS\Entities\Order;
use SphereMall\MS\Lib\Makers\OrderHistoryMaker;
use SphereMall\MS\Lib\Shop\OrderFinalized;
use SphereMall\MS\Resources\Resource;
use SphereMall\MS\Resources\Traits\DetailResource;

/**
 * Class OrdersResource
 * @package SphereMall\MS\Resources\Shop
 * @method Order get(int $id)
 * @method Order first()
 * @method Order[] all()
 * @method Order update($id, $data)
 * @method Order create($data)
 */
class OrdersResource extends Resource
{
    use DetailResource;

    #region [Override methods]
    public function getURI()
    {
        return "orders";
    }
    #endregion

    #region [Public methods]
    /**
     * Get full order data by orderId
     *
     * @param string $orderId
     *
     * @return null|OrderFinalized
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function byOrderId(string $orderId)
    {
        return $this->getOrderByParam("byorderid/$orderId");
    }

    /**
     * Get full order data by id
     *
     * @param int $id
     *
     * @return null|OrderFinalized
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function byId(int $id)
    {
        return $this->getOrderByParam("byid/$id");
    }

    /**
     * @param int $userId
     * @param int|null $id
     *
     * @return Order[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getHistory(int $userId, int $id = null)
    {
        $params = $this->getQueryParams();
        $uriAppend = "history/{$userId}" . (!is_null($id) ? "/{$id}" : '');
        $response = $this->handler->handle('GET', false, $uriAppend, $params);

        return $this->make($response, true, new OrderHistoryMaker());
    }
    #endregion

    #region [Private methods]
    /**
     * @param $uriAppend
     *
     * @return null|OrderFinalized
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getOrderByParam($uriAppend)
    {
        $params   = $this->getQueryParams();
        $response = $this->handler->handle('GET', false, $uriAppend, $params);

        $orderCollection = $this->make($response);
        if ($orderCollection) {
            $orderFinalized = new OrderFinalized($this->client);
            $orderFinalized->setOrderData($orderCollection[0]);

            return $orderFinalized;
        }

        return null;
    }
    #endregion
}
