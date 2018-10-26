<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 10/22/2017
 * Time: 7:36 PM
 */

namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\OrderItem;

/**
 * Class BasketMapper
 *
 * @package SphereMall\MS\Lib\Mappers
 */
class OrderItemsMapper extends Mapper
{
    #region [Protected methods]
    /**
     * @param array $array
     *
     * @return OrderItem
     */
    protected function doCreateObject(array $array)
    {
        $orderItem = new OrderItem($array['attributes']);

        if (isset($array['relationships']['products']) && is_array($array['relationships']['products'])) {
            $mapper = new ProductsMapper();
            foreach ($array['relationships']['products'] as $item) {
                $product            = array_merge($item['attributes'], $item['relationships']);
                $orderItem->product = $mapper->createObject($product);
            }
        }

        return $orderItem;
    }
    #endregion
}
