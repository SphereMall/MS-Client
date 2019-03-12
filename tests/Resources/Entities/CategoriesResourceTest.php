<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 08.03.2019
 * Time: 15:23
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\Categories;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class CategoriesResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testAll()
    {
        $categories = $this->client->categories();
        $list = $categories->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(Categories::class, $item);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetById()
    {
        $category = $this->client->categories();
        $testId = 1;
        $receivedId = $category->get($testId)->id;
        $this->assertEquals($testId, $receivedId);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testFirst()
    {
        $category = $this->client->categories()->first();
        $this->assertInstanceOf(Categories::class, $category);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDetailAll()
    {
        $categories = $this->client->categories()->detailAll();

        $this->assertInternalType('array', $categories);
        $this->assertGreaterThan(0, count($categories));
        $this->assertInstanceOf(Categories::class, $categories[0]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SphereMall\MS\Exceptions\EntityNotFoundException
     */
    public function testDetailById()
    {
        $category = $this->client->categories()->detailById(1);

        $this->assertTrue(is_array($category->attributes));
        $this->assertInstanceOf(Categories::class, $category);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SphereMall\MS\Exceptions\EntityNotFoundException
     */
    public function testDetailByUrl()
    {
        $category = $this->client->categories()->detailByCode('urlCodeTest');

        $this->assertTrue(is_array($category->attributes));
        $this->assertInstanceOf(Categories::class, $category);
    }
    #endregion
}
