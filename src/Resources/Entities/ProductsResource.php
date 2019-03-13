<?php
/**
 * Created by PHPStorm.
 * User: Serhii Kondratovec
 * Email: sergey@spheremall.com
 * Date: 13.10.2017
 * Time: 19:10
 */

namespace SphereMall\MS\Resources\Entities;

use SphereMall\MS\Entities\Product;
use SphereMall\MS\Resources\Resource;
use SphereMall\MS\Resources\Traits\DetailResource;
use SphereMall\MS\Resources\Traits\FullResource;
use SphereMall\MS\Resources\Traits\WithActions;

/**
 * Class ProductsResource
 * @package SphereMall\MS\Resources\Entities
 * @method Product get(int $id)
 * @method Product first()
 * @method Product[] all()
 * @method Product update($id, $data)
 * @method Product create($data)
 * @method Product|Product[] full($param = null)
 * @method Product[] fullAll()
 * @method Product fullById(int $id)
 * @method Product fullByCode(string $code)
 * @method Product|Product[] detail($param = null)
 * @method Product[] detailAll()
 * @method Product detailById(int $id)
 * @method Product detailByCode(string $code)
 */
class ProductsResource extends Resource
{
	use FullResource;
	use DetailResource;
	use WithActions;

	#region [Override methods]

	/**
	 * @return string
	 */
	public function getURI()
	{
		return "products";
	}

    /**
     * @param $ids
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
	public function getProductVariantsByIds($ids)
	{
		$this->ids($ids);
		$params = $this->getQueryParams();

		$uriAppend = 'detail/variants';
		$response = $this->handler->handle('GET', false, $uriAppend, $params);

		return $this->make($response);
	}

    /**
     * @param $id
     *
     * @return array|int|\SphereMall\MS\Entities\Entity|\SphereMall\MS\Lib\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
	public function getRelatedProducts($id)
	{
		$params = $this->getQueryParams();
		$uriAppend = "related/$id";
		$response = $this->handler->handle('GET', false, $uriAppend, $params);

		return $this->make($response);
	}
	#endregion
}
