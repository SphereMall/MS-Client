<?php
/**
 * Project PHP-MS-Client.
 * File: Page.php
 * Created by Sergey Yanchevsky
 * 15.02.2018 16:54
 */

namespace SphereMall\MS\Entities;

/**
 * Class Page
 * @package SphereMall\MS\Entities
 *
 * @property int $id;
 * @property int $langId;
 * @property int $websiteId;
 * @property int $relationId;
 * @property int $viewId;
 * @property string $urlCode;
 * @property int $masterPageId;
 * @property string $seoTitle;
 * @property string $seoDescription;
 * @property string $seoKeywords;
 * @property int $visible;
 * @property string $introHtml;
 * @property string $outroHtml;
 * @property string $title;
 * @property string $html;
 * @property string $shortDescription;
 * @property string $dateStartVisible;
 * @property string $dateEndVisible;
 * @property string $text1;
 * @property string $text2;
 * @property string $text3;
 * @property string $text4;
 * @property string $text5;
 * @property string $text6;
 * @property string $text7;
 * @property string $text8;
 * @property string $text9;
 * @property string $text10;
 * @property string $number1;
 * @property string $number2;
 * @property string $number3;
 * @property string $number4;
 * @property string $number5;
 * @property string $number6;
 * @property string $number7;
 * @property string $lastUpdate;
 * @property string $noindex;
 * @property int $functionalNameId;
 *
 * @property FunctionalName $functionalName
 * @property MasterPages $masterPage
 */
class Page extends Entity
{
    #region [Properties]
    public $id;
    public $langId;
    public $websiteId;
    public $relationId;
    public $viewId;
    public $urlCode;
    public $masterPageId;
    public $seoTitle;
    public $seoDescription;
    public $seoKeywords;
    public $visible;
    public $introHtml;
    public $outroHtml;
    public $title;
    public $html;
    public $shortDescription;
    public $dateStartVisible;
    public $dateEndVisible;
    public $text1;
    public $text2;
    public $text3;
    public $text4;
    public $text5;
    public $text6;
    public $text7;
    public $text8;
    public $text9;
    public $text10;
    public $number1;
    public $number2;
    public $number3;
    public $number4;
    public $number5;
    public $number6;
    public $number7;
    public $lastUpdate;
    public $noindex;
    public $functionalNameId;

    public $functionalName;
    public $masterPage;
    #endregion
}
