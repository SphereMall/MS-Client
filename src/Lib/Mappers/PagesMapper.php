<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 10/22/2017
 * Time: 7:36 PM
 */

namespace SphereMall\MS\Lib\Mappers;

use SphereMall\MS\Entities\Page;

/**
 * Class ProductsMapper
 * @package SphereMall\MS\Lib\Mappers
 */
class PagesMapper extends Mapper
{
    #region [Protected methods]
    /**
     * @param array $array
     *
     * @return Page
     */
    protected function doCreateObject(array $array)
    {
        $page = new Page($array);

        if (isset($array['functionalNames'][0])) {
            $mapper                  = new FunctionalNamesMapper();
            $page->functionalName = $mapper->createObject($array['functionalNames'][0]);

        }

        if (isset($array['masterPages'][0])) {
            $mapper                  = new MasterPagesMapper();
            $page->masterPage = $mapper->createObject($array['masterPages'][0]);

        }

        return $page;
    }
    #endregion
}
