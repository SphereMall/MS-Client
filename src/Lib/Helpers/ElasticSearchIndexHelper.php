<?php
/**
 * Created by PhpStorm.
 * User: DmitriyVorobey
 * Date: 20.02.2018
 * Time: 9:43
 */

namespace SphereMall\MS\Lib\Helpers;

/**
 * Class ElasticSearchIndexHelper
 *
 * @package SphereMall\MS\Lib\Helpers
 */
class ElasticSearchIndexHelper
{
    /**
     * @param string $className
     *
     * @return string
     */
    public static function getIndexByClass(string $className): string
    {
        $type = (new ClassReflectionHelper($className))->getShortLowerCaseName();

        return "sm-{$type}s";
    }

    /**
     * @param array $classes
     *
     * @return array
     */
    public static function getIndexesByClasses(array $classes)
    {
        return array_map(function ($class) {
            return self::getIndexByClass($class);
        }, $classes);
    }
}
