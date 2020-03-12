<?php
/**
 * Created by PhpStorm.
 * User: DimaSarno
 * Date: 10.08.2018
 * Time: 11:37
 */

namespace SphereMall\MS\Lib\Traits;

use SphereMall\MS\Entities\Media;
use SphereMall\MS\Exceptions\PropertyNotFoundException;
use SphereMall\MS\Lib\Specifications\Media\MediaTypes;

/**
 * Trait InteractsWithMedia
 * @package SphereMall\MS\Lib\Traits
 * @property Media[] $images
 * @property Media[] $files
 * @property Media[] $videos
 *
 */
trait InteractsWithMedia
{

    public $images = [];
    public $files = [];
    public $videos = [];

    #region [Get method]
    /**
     * @return Media|null
     */
    public function getMainImage()
    {
        $images = $this->getImages();
        return $images[0] ?? null;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->getMedia(MediaTypes::FILE_TYPE_ID, MediaTypes::FILE_TYPE_NAME);
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->getMedia(MediaTypes::IMAGE_TYPE_ID, MediaTypes::IMAGE_TYPE_NAME);
    }

    /**
     * @return array
     */
    public function getVideos(): array
    {
        return $this->getMedia(MediaTypes::VIDEO_TYPE_ID, MediaTypes::VIDEO_TYPE_NAME);
    }
    #endregion

    #region [Private methods]
    private function getMedia($type, $property)
    {
        if(property_exists('InteractsWithMedia', $property)) {
            throw new PropertyNotFoundException("Property {$property} not found");
        }
        if(!empty($this->{$property})) {
            return $this->{$property};
        }
        $this->setMediaByType($type, $property);
        return $this->{$property};
    }

    private function setMediaByType($type, $property)
    {
        $mediaFiles = [];
        if(!is_array($this->media)) {
            $this->{$property} = [];
            return;
        }
        foreach($this->get('mediaEntities') ?? [] as $mediaEntity) {
            $media = $this->media[$mediaEntity['id']] ?? null;
            if(!empty($media) && $media->get('mediaTypeId') == $type) {
                $media->orderNumber = $mediaEntity['orderNumber'] ?? null;
                $mediaFiles[] = $media;
            }
        }
        $this->{$property} = $this->sortMedia($mediaFiles);
    }

    private function sortMedia(array $media)
    {
        if(empty($media)) {
            return [];
        }
        usort($media, function ($a, $b) {
            if ($a->orderNumber == $b->orderNumber) {
                return 0;
            }
            return ($a->orderNumber < $b->orderNumber) ? -1 : 1;
        });
        return $media;
    }
    #endregion
}