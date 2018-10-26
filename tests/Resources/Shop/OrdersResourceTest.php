<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Shop;

use SphereMall\MS\Entities\Order;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class OrdersResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testGetList()
    {
        $all = $this->client->orders()->all();
        foreach ($all as $item) {
            $this->assertInstanceOf(Order::class, $item);
        }
    }

    public function testGetOrderById()
    {
        $order = $this->client->orders()->filter(['statusId' => ['e' => 2]])->first();
        $orderNew = $this->client->orders()->byId($order->id);
        $this->assertEquals($order->id, $orderNew->getId());
    }

    public function testUpdateOrder()
    {
        $order1 = $this->client->orders()->filter(['statusId' => ['e' => 2]])->first();
        $order2 = $this->client->orders()->byId($order1->id);
        $items = $order2->items;
        $order2->update(['paymentStatusId' => 2]);
        $this->assertEquals(2, $order2->getPaymentStatusId());
        $this->assertEquals($items, $order2->items);
    }

    public function testOrderHistory()
    {
        $all = $this->client->orders()->getHistory(2231);
        foreach ($all as $item) {
            $this->assertEquals(2231, $item->userId);
            $this->assertInstanceOf(Order::class, $item);
        }
    }
    #endregion
}

