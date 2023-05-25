<?php

namespace J4k\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * @see     https://vk.com/dev/fields
 *
 * @package J4k\OAuth2\Client\Provider
 */
class User implements ResourceOwnerInterface
{
    /**
     * @type array
     */
    protected $response;

    /**
     * User constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }
    /**
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
    /**
     * @return integer
     */
    public function getId()
    {
        return (int)($this->getField('uid') ?: $this->getField('id'));
    }

    /**
     * Helper for getting user data
     *
     * @param string $key
     *
     * @return mixed|null
     */
    protected function getField($key)
    {
        return !empty($this->response[$key]) ? $this->response[$key] : null;
    }

    /**
     * @return string|null DD.MM.YYYY
     */
    public function getBirthday()
    {
        return $this->getField('bdate');
    }
    /**
     * @return array [id =>, title => string]
     */
    public function getCity()
    {
        return $this->getField('city');
    }
    /**
     * @return array [id =>, title => string]
     */
    public function getCountry()
    {
        return $this->getField('country');
    }
    /**
     * Short address to user page
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->getField('domain');
    }
    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->getField('first_name');
    }
    /**
     * @return int 0|1|2|3 => nobody|resquest_sent|incoming_request|friends
     */
    public function getFriendStatus()
    {
        return $this->getField('friend_Status');
    }
    /**
     * Has user avatar?
     *
     * @return bool
     */
    public function isHasPhoto()
    {
        return (bool)$this->getField('has_photo');
    }
    /**
     * @return string
     */
    public function getHomeTown()
    {
        return $this->getField('home_town');
    }
    /**
     * Detect if current user is freind to this
     *
     * @return bool
     */
    public function isFriend()
    {
        return (bool)$this->getField('is_friend');
    }
    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->getField('last_name');
    }
    /**
     * @return string
     */
    public function getMaidenName()
    {
        return $this->getField('maiden_name');
    }
    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->getField('nickname');
    }
    /**
     * It's square!
     *
     * @return string URL
     */
    public function getPhotoMax()
    {
        return $this->getField('photo_max');
    }
    /**
     * Any sizes
     *
     * @return string URL
     */
    public function getPhotoMaxOrig()
    {
        return $this->getField('photo_max_orig');
    }
    /**
     * @return string
     */
    public function getScreenName()
    {
        return $this->getField('screen_name');
    }
    /**
     * @return int 1|2 => woman|man
     */
    public function getSex()
    {
        return $this->getField('sex');
    }
}
