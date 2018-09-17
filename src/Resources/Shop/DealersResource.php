<?php
/**
 * Created by PhpStorm.
 * User: YaroslavDraha
 * Date: 17.09.2018
 * Time: 23:32
 */

namespace SphereMall\MS\Resources\Shop;


use SphereMall\MS\Entities\Dealer;
use SphereMall\MS\Resources\Resource;

class DealersResource extends Resource
{
    #region [Override methods]
    public function getURI()
    {
        return "dealers";
    }
    #endregion

    #region [Public methods]
    /**
     * Detail dealer information
     * @param $id
     */
    public function detail(int $id)
    {
        $response = $this->handler->handle('GET', false, 'detail/' . $id);
        return $this->make($response, false);
    }

    /**
     * Detail dealer information with additional request to addresses
     * @param $id
     * @return Dealer
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function detailWithAddresses($id)
    {
        $dealer = $this->detail($id);

        if ($dealer->dealersToAddresses) {
            $addressesId = array_map(function($value) {
                return $value['addressId'];
            }, $dealer->dealersToAddresses);

            $addresses = $this->client->addresses()
                ->ids(array_values($addressesId))
                ->all();

            $dealer->addresses = $addresses;
        }

        return $dealer;
    }
    #endregion
}