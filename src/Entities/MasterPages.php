<?php
/**
 * Project PHP-MS-Client.
 * File: MasterPages.php
 * Created by Sergey Yanchevsky
 * 15.02.2018 17:05
 */

namespace SphereMall\MS\Entities;

/**
 * Class MasterPages
 * @package SphereMall\MS\Entities
 */
class MasterPages extends Entity
{
    #region [Properties]
    public $id;
    public $langId;
    public $title;
    public $viewId;
    public $filePath;
    public $relationId;
    public $websiteId;
    #endregion
}
