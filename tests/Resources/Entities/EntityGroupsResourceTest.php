<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 08.03.2019
 * Time: 15:24
 */

namespace SphereMall\MS\Tests\Resources\Entities;

use SphereMall\MS\Entities\EntityGroups;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class EntityGroupsResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testServiceGetList()
    {
        $categories = $this->client->entityGroups();
        $list = $categories->all();

        foreach ($list as $item) {
            $this->assertInstanceOf(EntityGroups::class, $item);
        }
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGetById()
    {
        $category = $this->client->entityGroups();
        $testId = 1;
        $receivedId = $category->get($testId)->id;
        $this->assertEquals($testId, $receivedId);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testFirst()
    {
        $entityGroup = $this->client->entityGroups()->first();
        $this->assertInstanceOf(EntityGroups::class, $entityGroup);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testDetailAll()
    {
        $entityGroups = $this->client->entityGroups()->detailAll();

        $this->assertInternalType('array', $entityGroups);
        $this->assertGreaterThan(0, count($entityGroups));
        $this->assertInstanceOf(EntityGroups::class, $entityGroups[0]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SphereMall\MS\Exceptions\EntityNotFoundException
     */
    public function testDetailById()
    {
        $entityGroup = $this->client->entityGroups()->detailById(1);

        $this->assertTrue(is_array($entityGroup->attributes));
        $this->assertInstanceOf(EntityGroups::class, $entityGroup);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \SphereMall\MS\Exceptions\EntityNotFoundException
     */
    public function testDetailByUrl()
    {
        $entityGroup = $this->client->entityGroups()->detailByCode('http');

        $this->assertTrue(is_array($entityGroup->attributes));
        $this->assertInstanceOf(EntityGroups::class, $entityGroup);
    }
    #endregion
}
