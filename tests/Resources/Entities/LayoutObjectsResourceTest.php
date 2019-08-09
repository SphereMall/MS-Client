<?php
namespace SphereMall\MS\Tests\Resources\Entities;


use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class LayoutObjectsResourceTest extends SetUpResourceTest
{
    private $objectExample = [
        "type"          => "bannerObject",
        "attributes"    => [
            "backgroundImage"       => "{SITE_URL}/frontend/Channels/demo/webcontent/images/demo-image2.jpg",
            "textColor"             => "#000000",
            "pageUrl"               => null,
            "blockOpacity"          => "0.9",
            "cssClass"              => "Facilement le plus beau chez-soi",
            "alignDescription"      => "313",
            "buttonLabel"           => "Button",
            "backgroundColor"       => "#f5f5f5",
            "additionalMedia"       => null,
            "backgroundMobileImage" => "https://spheremall.com/frontend/webcontent/images/home/AboutUs_01-min.jpg",
            "fullBannerClickable"   => "0",
            "titleTag"              => null,
            "title"                 => "Test - 1 bannerObject from MS-12",
            "html"                  => null,
        ],
        "relationships" => [],
    ];


    #region [Test methods]

    public function testLayoutObjectsCreate()
    {
        $newObject = $this->client
            ->layoutObjects()
            ->createObject($this->objectExample);

        $this->assertEquals(1, count($newObject));

        return (array) $newObject[0];
    }

    /**
     * @depends testLayoutObjectsCreate
     */
    public function testLayoutObjectsUpdate($attributes)
    {
        $object = [
            "type"       => $this->objectExample['type'],
            "id"         => $attributes['id'],
            "attributes" => $attributes,
        ];

        $object["attributes"]['title'] = 'Test - 1 bannerObject from MS-13';

        $updateObjects = $this->client
            ->layoutObjects()
            ->updateObject([$object]);

        $this->assertEquals(1, count($updateObjects));

        return (array) $updateObjects[0];
    }

    /**
     * @depends testLayoutObjectsUpdate
     */
    public function   testLayoutObjectsGetById($object)
    {
        $responce = $this->client
            ->layoutObjects()
            ->setObjectType($this->objectExample['type'])
            ->getById($object['id']);

        $this->assertEquals(1, count($responce));
    }


    public function   testLayoutObjectsGetByUrlCode()
    {
        $response = $this->client
            ->layoutObjects()
            ->setObjectType('Leading')
            ->getByUrlCode('home');

        $this->assertEquals('Home', $response[0]->pageTitle);
    }

    public function   testLayoutObjectsGetObjects()
    {
        $data = [
            ["type" => "bannerObject", "id" => 47],
            ["type" => "Leading", "urlCode" => "home"],
        ];

        $response = $this->client
            ->layoutObjects()
            ->getObjects($data);

        $this->assertArrayHasKey('id', (array)$response[0]);
    }
    #endregion
}
