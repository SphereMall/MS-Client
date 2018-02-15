<?php
/**
 * Created by PHPStorm.
 * User: Serhey Yanchevsky
 * Email: s.yanchevsky@spheremall.com
 * Date: 15/02/2018
 * Time: 17:08
 */

namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\MasterPages;

/**
 * Class MasterPagesMapper
 * @package SphereMall\MS\Lib\Mappers
 */
class MasterPagesMapper extends Mapper
{
    #region [Protected methods]
    /**
     * @param array $array
     *
     * @return MasterPages
     */
    protected function doCreateObject(array $array)
    {
        return new MasterPages($array);
    }
    #endregion
}
