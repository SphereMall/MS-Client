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
use SphereMall\MS\Entities\WebSite;
use SphereMall\MS\Entities\WebSiteSetting;
use SphereMall\MS\Lib\Http\LayoutObjectsRequest;
use SphereMall\MS\Lib\Makers\ElasticIndexerResponseMaker;
use SphereMall\MS\Lib\Makers\ElasticSearchMaker;
use SphereMall\MS\Lib\Shop\Basket;
use SphereMall\MS\Resources\Catalog\CatalogItemAttributesResource;
use SphereMall\MS\Resources\ChangesHistory\HistoryResource;
use SphereMall\MS\Resources\Channels\ChannelsResource;
use SphereMall\MS\Resources\Channels\WebSiteSettingsResource;
use SphereMall\MS\Resources\Channels\WebSitesResource;
use SphereMall\MS\Resources\Comments\CommentsResource;
use SphereMall\MS\Resources\Comments\EntitiesAverageRating;
use SphereMall\MS\Resources\ElasticSearch\ElasticIndexerResource;
use SphereMall\MS\Resources\ElasticSearch\ElasticResource;
use SphereMall\MS\Resources\ElasticSearch\ElasticSearchResource;
use SphereMall\MS\Resources\Entities\CategoriesResource;
use SphereMall\MS\Resources\Entities\EntityGroupsResource;
use SphereMall\MS\Resources\Grapher\CorrelationsResource;
use SphereMall\MS\Resources\Grapher\EntityFactorsResource;
use SphereMall\MS\Resources\Grapher\EntityRelevanceResource;
use SphereMall\MS\Resources\Grapher\FactorsResource;
use SphereMall\MS\Resources\Grapher\FactorValuesResource;
use SphereMall\MS\Resources\Grapher\UserFingerprintsResource;
use SphereMall\MS\Resources\Grapher\UserUidHashResource;
use SphereMall\MS\Resources\LayoutContent\MenuItemsResource;
use SphereMall\MS\Resources\Marketing\ActionsResource;
use SphereMall\MS\Resources\Marketing\ActionsTypesResource;
use SphereMall\MS\Resources\Marketing\CampaignsResource;
use SphereMall\MS\Resources\Marketing\CampaignsTreeResource;
use SphereMall\MS\Resources\Marketing\EventActionCampaignResource;
use SphereMall\MS\Resources\Marketing\EventsResource;
use SphereMall\MS\Resources\Marketing\TriggersResource;
use SphereMall\MS\Resources\Marketing\TriggersTypesResource;
use SphereMall\MS\Resources\Marketing\UserTriggerHistoryResource;
use SphereMall\MS\Resources\Marketing\UserTriggersResource;
use SphereMall\MS\Resources\Prices\PriceConfigurationsResource;
use SphereMall\MS\Resources\Prices\ProductPriceConfigurationsResource;
use SphereMall\MS\Resources\Entities\AttributeDisplayTypesResource;
use SphereMall\MS\Resources\Entities\AttributeGroupsEntitiesResource;
use SphereMall\MS\Resources\Entities\AttributeGroupsResource;
use SphereMall\MS\Resources\Entities\AttributesResource;
use SphereMall\MS\Resources\Entities\AttributeTypesResource;
use SphereMall\MS\Resources\Entities\AttributeValuesResource;
use SphereMall\MS\Resources\Entities\BrandsResource;
use SphereMall\MS\Resources\Entities\CatalogItemsResource;
use SphereMall\MS\Resources\Entities\DocumentsResource;
use SphereMall\MS\Resources\Entities\EntitiesResource;
use SphereMall\MS\Resources\Entities\EntityAttributesResource;
use SphereMall\MS\Resources\Entities\FunctionalNamesResource;
use SphereMall\MS\Resources\Entities\MediaResource;
use SphereMall\MS\Resources\Entities\MediaTypesResource;
use SphereMall\MS\Resources\Entities\OptionsResource;
use SphereMall\MS\Resources\Entities\ProductAttributeValuesResource;
use SphereMall\MS\Resources\Entities\ProductsResource;
use SphereMall\MS\Resources\Entities\ProductVariantsResource;
use SphereMall\MS\Resources\Entities\LayoutObjectsResource;
use SphereMall\MS\Resources\Entities\UnitOfMeasureResource;
use SphereMall\MS\Resources\Grapher\ConsumerFactorsResource;
use SphereMall\MS\Resources\Grapher\GridResource;
use SphereMall\MS\Resources\Shop\BasketResource;
use SphereMall\MS\Resources\Shop\CurrenciesRateResource;
use SphereMall\MS\Resources\Shop\CurrenciesResource;
use SphereMall\MS\Resources\Shop\DealersResource;
use SphereMall\MS\Resources\Shop\DeliveryPaymentsResource;
use SphereMall\MS\Resources\Shop\DeliveryProvidersResource;
use SphereMall\MS\Resources\Shop\DiscountTypesResource;
use SphereMall\MS\Resources\Shop\InvoicesResource;
use SphereMall\MS\Resources\Shop\OrderItemsResource;
use SphereMall\MS\Resources\Shop\OrdersResource;
use SphereMall\MS\Resources\Shop\OrderStatusesResource;
use SphereMall\MS\Resources\Shop\PaymentMethodsResource;
use SphereMall\MS\Resources\Shop\PaymentProvidersResource;
use SphereMall\MS\Resources\Shop\PromotionsResource;
use SphereMall\MS\Resources\Shop\RulesResource;
use SphereMall\MS\Resources\Shop\VatsResource;
use SphereMall\MS\Resources\StaticTexts\WebTextsResource;
use SphereMall\MS\Resources\Users\AddressResource;
use SphereMall\MS\Resources\Users\CompaniesResource;
use SphereMall\MS\Resources\Users\MessagesResource;
use SphereMall\MS\Resources\Users\UserAdditionalDataResource;
use SphereMall\MS\Resources\Users\UsersResource;
use SphereMall\MS\Resources\Users\WishListItemsResource;
use SphereMall\MS\Resources\Users\WishListResource;

/**
 * Trait ServiceInjector
 * @package SphereMall\MS\Lib
 * @static  Shop $basket
 */
trait ServiceInjector
{
    #region [Properties]
    protected static $basket = null;
    #endregion

    #region [Entities service]
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


    public function layoutObjects()
    {
        /** @var Client $this */
        return new LayoutObjectsResource($this);
    }


    /**
     * @return ProductVariantsResource
     */
    public function productVariants()
    {
        /** @var Client $this */
        return new ProductVariantsResource($this);
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
     * @return UnitOfMeasureResource
     */
    public function unitOfMeasure()
    {
        /** @var Client $this */
        return new UnitOfMeasureResource($this);
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

    /**
     * @return CategoriesResource
     */
    public function categories()
    {
        /** @var Client $this */
        return new CategoriesResource($this);
    }

    /**
     * @return EntityGroupsResource
     */
    public function entityGroups()
    {
        /** @var Client $this */
        return new EntityGroupsResource($this);
    }
    #endregion

    #region [Marketing service]
    /**
     * @return ActionsResource
     */
    public function actions()
    {
        /** @var Client $this */
        return new ActionsResource($this);
    }

    /**
     * @return ActionsTypesResource
     */
    public function actionsTypes()
    {
        /** @var Client $this */
        return new ActionsTypesResource($this);
    }

    /**
     * @return CampaignsResource
     */
    public function campaigns()
    {
        /** @var Client $this */
        return new CampaignsResource($this);
    }

    /**
     * @return CampaignsTreeResource
     */
    public function campaignsTree()
    {
        /** @var Client $this */
        return new CampaignsTreeResource($this);
    }

    /**
     * @return EventActionCampaignResource
     */
    public function eventActionCampaign()
    {
        /** @var Client $this */
        return new EventActionCampaignResource($this);
    }

    /**
     * @return EventsResource
     */
    public function events()
    {
        /** @var Client $this */
        return new EventsResource($this);
    }

    /**
     * @return TriggersResource
     */
    public function triggers()
    {
        /** @var Client $this */
        return new TriggersResource($this);
    }

    /**
     * @return TriggersTypesResource
     */
    public function triggersTypes()
    {
        /** @var Client $this */
        return new TriggersTypesResource($this);
    }

    /**
     * @return UserTriggerHistoryResource
     */
    public function userTriggerHistory()
    {
        /** @var Client $this */
        return new UserTriggerHistoryResource($this);
    }

    /**
     * @return UserTriggersResource
     */
    public function userTriggers()
    {
        /** @var Client $this */
        return new UserTriggersResource($this);
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
     * @param string $version
     * @return BasketResource
     */
    public function basketResource(string $version = 'v2')
    {
        /** @var Client $this */
        return new BasketResource($this, $version);
    }

    /**
     * @param int|null $id
     * @param string $version
     * @return null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SphereMall\MS\Exceptions\EntityNotFoundException
     */
    public function basket(int $id = null, string $version = 'v2')
    {
        if (is_null(static::$basket)) {
            /** @var Client $this */
            static::$basket = new Basket($this, $id, $version);
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
     * @return PromotionsResource
     */
    public function promotions()
    {
        /** @var Client $this */
        return new PromotionsResource($this);
    }

    /**
     * @return RulesResource
     */
    public function rules()
    {
        /** @var Client $this */
        return new RulesResource($this);
    }

    /**
     * @return DiscountTypesResource
     */
    public function discountTypes()
    {
        /** @var Client $this */
        return new DiscountTypesResource($this);
    }

    /**
     * @return DealersResource
     */
    public function dealers()
    {
        /** @var Client $this */
        return new DealersResource($this);
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
     * @return FactorsResource
     */
    public function factors()
    {
        /** @var Client $this */
        return new FactorsResource($this);
    }

    /**
     * @return FactorValuesResource
     */
    public function factorValues()
    {
        /** @var Client $this */
        return new FactorValuesResource($this);
    }

    /**
     * @return EntityFactorsResource
     */
    public function entityFactors()
    {
        /** @var Client $this */
        return new EntityFactorsResource($this);
    }

    /**
     * @return ConsumerFactorsResource
     */
    public function consumerFactors()
    {
        /** @var Client $this */
        return new ConsumerFactorsResource($this);
    }

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

    public function entityRelevance()
    {
        /** @var Client $this */
        return new EntityRelevanceResource($this);
    }

    public function userFingerprints()
    {
        /** @var Client $this */
        return new UserFingerprintsResource($this);
    }

    public function userUidHash()
    {
        /** @var Client $this */
        return new UserUidHashResource($this);
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

    #region [StaticTexts service]
    /**
     * @return WebTextsResource
     */
    public function webTexts()
    {
        /** @var Client $this */
        return new WebTextsResource($this);
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

    #region [Price service]
    /**
     * @return PriceConfigurationsResource
     */
    public function priceConfigurations()
    {
        /** @var Client $this */
        return new PriceConfigurationsResource($this);
    }
    #endregion

    #region [ElasticSearch service]
    public function elastic()
    {
        /** @var Client $this */
        return new ElasticResource($this);
    }

    /**
     * @param bool $multi
     * @return ElasticSearchResource
     */
    public function elasticSearch($multi = false)
    {
        /** @var Client $this */
        return new ElasticSearchResource($this, null, null, new ElasticSearchMaker(), $multi);
    }
    #endregion

    #region [ElasticIndexer service]
    /**
     * @return ElasticIndexerResource
     */
    public function elasticIndexer()
    {
        /** @var Client $this */
        return new ElasticIndexerResource($this, null, null, new ElasticIndexerResponseMaker());
    }

    /**
     * @return CommentsResource
     */
    public function comments()
    {
        /** @var Client $this */
        return new CommentsResource($this);
    }

    /**
     * @return EntitiesAverageRating
     */
    public function entitiesAverageRating()
    {
        /** @var Client $this */
        return new EntitiesAverageRating($this);
    }

    /**
     * @return WishListResource
     */
    public function wishList()
    {
        /** @var Client $this */
        return new WishListResource($this);
    }

    /**
     * @return UserAdditionalDataResource
     */
    public function userAdditionalData()
    {
        /** @var Client $this */
        return new UserAdditionalDataResource($this);
    }

    /**
     * @return CatalogItemAttributesResource
     */
    public function catalogItemAttributes()
    {
        /** @var Client $this */
        return new CatalogItemAttributesResource($this);
    }

    /**
     * @return MenuItemsResource
     */
    public function menuItems()
    {
        /** @var Client $this */
        return new MenuItemsResource($this);
    }
    #endregion

    #region [Changes history service]
    /**
     * @return HistoryResource
     */
    public function history()
    {
        /** @var Client $this */
        return new HistoryResource($this);
    }
    #endregion

    #region [Channels service]
    /**
     * @return WebSitesResource
     */
    public function webSites()
    {
        /** @var Client $this */
        return new WebSitesResource($this);
    }

    /**
     * @return ChannelsResource
     */
    public function channels()
    {
        /** @var Client $this */
        return new ChannelsResource($this);
    }

    /**
     * @return WebSiteSettingsResource
     */
    public function webSiteSettings()
    {
        /** @var Client $this */
        return new WebSiteSettingsResource($this);
    }
    #endregion
}
