<?php

namespace App\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserMenu
 */
class UserMenu
{
    /**
     * @var integer
     */
    private $position;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set position
     *
     * @param integer $position
     * @return UserMenu
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return UserMenu
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return UserMenu
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return UserMenu
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return UserMenu
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
