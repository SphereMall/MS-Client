<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 20:02
 */

namespace SphereMall\MS\Tests\Resources\Documents;

use SphereMall\MS\Entities\Document;
use SphereMall\MS\Lib\Collection;
use SphereMall\MS\Tests\Resources\SetUpResourceTest;

class DocumentsResourceTest extends SetUpResourceTest
{
    #region [Test methods]
    public function testDocumentFull()
    {
        $documents = $this->client
            ->documents()
            ->limit(1)
            ->full();

        $this->assertEquals(1, count($documents));
    }

    public function testDocumentDetail()
    {
        $documents = $this->client
            ->documents()
            ->limit(1)
            ->detailAll();

        $this->assertEquals(1, count($documents));
    }

    public function testAttributeHelpMethods()
    {
        $documents = $this->client
            ->documents()
            ->limit(1)
            ->full();

        $attribute = $documents[0]->getAttributeByCode('title');
        $this->assertEquals('title', $attribute->code);

        $attributeValue = $documents[0]->getFirstValueByAttributeCode('title');
        $this->assertEquals('test attribute value', $attributeValue->value);

    }
    #endregion
}
