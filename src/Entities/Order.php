<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 08.10.2017
 * Time: 21:37
 */

namespace SphereMall\MS\Entities;

/**
 * Class Order
 *
 * @package SphereMall\MS\Entities
 * @property int             $id
 * @property string          $orderId
 * @property int             $userId
 * @property int             $statusId
 * @property int             $paymentStatusId
 * @property int             $paymentId
 * @property int             $itemsAmount
 * @property int             $deliveryProviderId
 * @property int             $paymentMethodId
 * @property int             $shippingAddressId
 * @property int             $billingAddressId
 * @property string          $deliveryTime
 * @property int             $deliveryStatusId
 * @property int             $currency
 * @property string          $additionalInfo
 * @property string          $orderComment
 * @property int             $deliveryCost
 * @property int             $subTotalVatPrice
 * @property int             $totalVatPrice
 * @property int             $subTotalPrice
 * @property int             $totalPrice
 * @property int             $totalPriceWithoutDelivery
 * @property string          $createDate
 * @property string          $updateDate
 *
 * @property OrderItem[]     $items
 * @property PaymentMethod[] $paymentMethods
 */
class Order extends Entity
{
    #region [Properties]
    public $id;
    public $orderId;
    public $userId;
    public $statusId;
    public $paymentStatusId;
    public $paymentId;
    public $itemsAmount;
    public $deliveryProviderId;
    public $paymentMethodId;
    public $shippingAddressId;
    public $billingAddressId;
    public $deliveryTime;
    public $deliveryStatusId;
    public $currency;
    public $additionalInfo;
    public $orderComment;
    public $deliveryCost;
    public $subTotalVatPrice;
    public $totalVatPrice;
    public $subTotalPrice;
    public $totalPrice;
    public $totalPriceWithoutDelivery;
    public $createDate;
    public $updateDate;

    public $items          = [];
    public $paymentMethods = [];
    #endregion
}
