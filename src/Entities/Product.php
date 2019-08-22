<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 08.10.2017
 * Time: 21:37
 */

namespace SphereMall\MS\Entities;

use SphereMall\MS\Lib\Traits\InteractsWithAttributes;
use SphereMall\MS\Lib\Traits\InteractsWithMedia;

/**
 * Class Product
 * @package SphereMall\MS\Entities
 * @property int $id
 * @property string $urlCode
 * @property string $title
 * @property string $shortDescription
 * @property string $fullDescription
 * @property string $seoDescription
 * @property string $seoKeywords
 * @property int $visible
 * @property int $purchasePrice
 * @property int $price
 * @property int $oldPrice
 * @property string $importedId
 * @property string $variantsCompound
 * @property Attribute[] $attributes
 * @property Brand $brand
 * @property FunctionalName $functionalName
 * @property Category[] $categories
 * @property EntityGroup[] $entityGroups
 * @property Media[] $media
 * @property Media $mainMedia
 * @property Promotion[] $promotions
 * @property ProductToPromotions[] $productsToPromotions
 * @property Option[] $options
 */
class Product extends AutoCompleteEntity
{
    use InteractsWithAttributes;
    use InteractsWithMedia;

    #region [Properties]
    public $shortDescription;
    public $fullDescription;
    public $seoTitle;
    public $seoDescription;
    public $seoKeywords;
    public $visible;
    public $purchasePrice;
    public $price;
    public $oldPrice;
    public $importedId;
    public $variantsCompound;

    public $attributes;
    public $brand;
    public $functionalName;
    public $categories;
    public $entityGroups;

    public $media;
    public $mainMedia;

    public $promotions;
    public $productsToPromotions;

    public $options;
    #endregion
}