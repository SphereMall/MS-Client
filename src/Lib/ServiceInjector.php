<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 18:37
 */

namespace SphereMall\MS\Lib;

use SphereMall\MS\Client;
use SphereMall\MS\Resources\Documents\DocumentsResource;
use SphereMall\MS\Resources\Elasticsearch\ElasticsearchResource;
use SphereMall\MS\Resources\Grapher\CorrelationsResource;
use SphereMall\MS\Resources\Prices\ProductPriceConfigurationsResource;
use SphereMall\MS\Resources\Products\AttributeDisplayTypesResource;
use SphereMall\MS\Resources\Products\AttributeGroupsEntitiesResource;
use SphereMall\MS\Resources\Products\AttributeTypesResource;
use SphereMall\MS\Resources\Products\CatalogItemsResource;
use SphereMall\MS\Resources\Products\EntitiesResource;
use SphereMall\MS\Resources\Products\EntityAttributesResource;
use SphereMall\MS\Resources\Products\MediaTypesResource;
use SphereMall\MS\Resources\Products\OptionsResource;
use SphereMall\MS\Resources\Products\AttributeGroupsResource;
use SphereMall\MS\Resources\Products\AttributesResource;
use SphereMall\MS\Resources\Products\AttributeValuesResource;
use SphereMall\MS\Resources\Products\BrandsResource;
use SphereMall\MS\Resources\Products\FunctionalNamesResource;
use SphereMall\MS\Resources\Products\MediaResource;
use SphereMall\MS\Resources\Products\ProductAttributeValuesResource;
use SphereMall\MS\Resources\Products\ProductsResource;
use SphereMall\MS\Resources\Shop\InvoicesResource;
use SphereMall\MS\Resources\Shop\OrderItemsResource;
use SphereMall\MS\Resources\Shop\CouponsResource;
use SphereMall\MS\Resources\Users\AddressResource;
use SphereMall\MS\Resources\Users\CompaniesResource;
use SphereMall\MS\Resources\Users\MessagesResource;
use SphereMall\MS\Resources\Users\UsersResource;
use SphereMall\MS\Lib\Shop\Basket;
use SphereMall\MS\Resources\Shop\OrdersResource;
use SphereMall\MS\Resources\Shop\PaymentMethodsResource;
use SphereMall\MS\Resources\Shop\DeliveryPaymentsResource;
use SphereMall\MS\Resources\Shop\DeliveryProvidersResource;
use SphereMall\MS\Resources\Shop\OrderStatusesResource;
use SphereMall\MS\Resources\Shop\PaymentProvidersResource;
use SphereMall\MS\Resources\Shop\BasketResource;
use SphereMall\MS\Resources\Shop\CurrenciesRateResource;
use SphereMall\MS\Resources\Shop\CurrenciesResource;
use SphereMall\MS\Resources\Shop\VatsResource;
use SphereMall\MS\Resources\Grapher\GridResource;
use SphereMall\MS\Resources\Users\WishListItemsResource;

/**
 * Trait ServiceInjector
 * @package SphereMall\MS\Lib
 * @static Shop $basket
 */
trait ServiceInjector
{
    #region [Properties]
    protected static $basket = null;
    #endregion

    #region [Products service]
    /**
     * @return AttributeDisplayTypesResource
     */
    public function attributeDisplayTypes()
    {
        /** @var Client $this */
        return new AttributeDisplayTypesResource($this);
    }

    /**
     * @return AttributeTypesResource
     */
    public function attributeTypes()
    {
        /** @var Client $this */
        return new AttributeTypesResource($this);
    }

    /**
     * @return AttributeGroupsEntitiesResource
     */
    public function attributeGroupsEntities()
    {
        /** @var Client $this */
        return new AttributeGroupsEntitiesResource($this);
    }

    /**
     * @return ProductsResource
     */
    public function products()
    {
        /** @var Client $this */
        return new ProductsResource($this);
    }

    /**
     * @return AttributesResource
     */
    public function attributes()
    {
        /** @var Client $this */
        return new AttributesResource($this);
    }

    /**
     * @return AttributeGroupsResource
     */
    public function attributeGroups()
    {
        /** @var Client $this */
        return new AttributeGroupsResource($this);
    }

    /**
     * @return AttributeValuesResource
     */
    public function attributeValues()
    {
        /** @var Client $this */
        return new AttributeValuesResource($this);
    }

    /**
     * @return BrandsResource
     */
    public function brands()
    {
        /** @var Client $this */
        return new BrandsResource($this);
    }

    /**
     * @return FunctionalNamesResource
     */
    public function functionalNames()
    {
        /** @var Client $this */
        return new FunctionalNamesResource($this);
    }

    /**
     * @return MediaResource
     */
    public function media()
    {
        /** @var Client $this */
        return new MediaResource($this);
    }

    /**
     * @return MediaTypesResource
     */
    public function mediaTypes()
    {
        /** @var Client $this */
        return new MediaTypesResource($this);
    }

    /**
     * @return ProductAttributeValuesResource
     */
    public function productAttributeValues()
    {
        /** @var Client $this */
        return new ProductAttributeValuesResource($this);
    }

    /**
     * @return EntitiesResource
     */
    public function entities()
    {
        /** @var Client $this */
        return new EntitiesResource($this);
    }

    /**
     * @return EntityAttributesResource
     */
    public function entityAttributes()
    {
        /** @var Client $this */
        return new EntityAttributesResource($this);
    }

    /**
     * @return OptionsResource
     */
    public function options()
    {
        /** @var Client $this */
        return new OptionsResource($this);
    }

    /**
     * @return CatalogItemsResource
     */
    public function catalogItems()
    {
        /** @var Client $this */
        return new CatalogItemsResource($this);
    }
    #endregion

    #region [Shop service]
    /**
     * @return OrdersResource
     */
    public function orders()
    {
        /** @var Client $this */
        return new OrdersResource($this);
    }

    /**
     * @return BasketResource
     */
    public function basketResource()
    {
        /** @var Client $this */
        return new BasketResource($this, "v2");
    }

    /**
     * @param int|null $id
     * @return Basket
     */
    public function basket(int $id = null)
    {
        if (is_null(static::$basket)) {
            /** @var Client $this */
            static::$basket = new Basket($this, $id);
        }

        return static::$basket;
    }

    /**
     * @return DeliveryProvidersResource
     */
    public function deliveryProviders()
    {
        /** @var Client $this */
        return new DeliveryProvidersResource($this);
    }

    /**
     * @return PaymentMethodsResource
     */
    public function paymentMethods()
    {
        /** @var Client $this */
        return new PaymentMethodsResource($this);
    }

    /**
     * @return DeliveryPaymentsResource
     */
    public function deliveryPayments()
    {
        /** @var Client $this */
        return new DeliveryPaymentsResource($this);
    }

    /**
     * @return OrderStatusesResource
     */
    public function orderStatuses()
    {
        /** @var Client $this */
        return new OrderStatusesResource($this);
    }

    /**
     * @return PaymentProvidersResource
     */
    public function paymentProviders()
    {
        /** @var Client $this */
        return new PaymentProvidersResource($this);
    }


    /**
     * @return VatsResource
     */
    public function vats()
    {
        /** @var Client $this */
        return new VatsResource($this);
    }

    /**
     * @return CurrenciesResource
     */
    public function currencies()
    {
        /** @var Client $this */
        return new CurrenciesResource($this);
    }

    /**
     * @return CurrenciesRateResource
     */
    public function currenciesRate()
    {
        /** @var Client $this */
        return new CurrenciesRateResource($this);
    }

    /**
     * @return InvoicesResource
     */
    public function invoices()
    {
        /** @var Client $this */
        return new InvoicesResource($this);
    }

    /**
     * @return OrderItemsResource
     */
    public function orderItems()
    {
        /** @var Client $this */
        return new OrderItemsResource($this);
    }

    /**
     * @return CouponsResource
     */
    public function promotions()
    {
        /** @var Client $this */
        return new CouponsResource($this);
    }
    #endregion

    #region [Users service]
    /**
     * @return AddressResource
     */
    public function addresses()
    {
        /** @var Client $this */
        return new AddressResource($this);
    }

    /**
     * @return UsersResource
     */
    public function users()
    {
        /** @var Client $this */
        return new UsersResource($this);
    }

    /**
     * @return CompaniesResource
     */
    public function companies()
    {
        /** @var Client $this */
        return new CompaniesResource($this);
    }

    /**
     * @return MessagesResource
     */
    public function messages()
    {
        /** @var Client $this */
        return new MessagesResource($this);
    }

    /**
     * @return WishListItemsResource
     */
    public function wishListItems()
    {
        /** @var Client $this */
        return new WishListItemsResource($this);
    }
    #endregion

    #region [Grapher service]
    /**
     * @return GridResource
     */
    public function grid()
    {
        /** @var Client $this */
        return new GridResource($this);
    }

    /**
     * @return CorrelationsResource
     */
    public function correlations()
    {
        /** @var Client $this */
        return new CorrelationsResource($this);
    }
    #endregion

    #region [Documents service]
    /**
     * @return DocumentsResource
     */
    public function documents()
    {
        /** @var Client $this */
        return new DocumentsResource($this);
    }
    #endregion

    #region [Elasticsearch service]
    /**
     * @return ElasticsearchResource
     */
    public function elasticsearch()
    {
        /** @var Client $this */
        return new ElasticsearchResource($this);
    }
    #endregion

    #region [Price service]
    /**
     * @return ProductPriceConfigurationsResource
     */
    public function productPriceConfigurations()
    {
        /** @var Client $this */
        return new ProductPriceConfigurationsResource($this);
    }
    #endregion
}
