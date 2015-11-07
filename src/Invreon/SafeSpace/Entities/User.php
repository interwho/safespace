<?php
namespace Invreon\SafeSpace\Entities;

// src/Invreon/SafeSpace/Entities/User.php
/**
 * @Entity
 * @Table(name="user")
 */
class User
{
    /** @Id @Column(type="integer") @GeneratedValue * */
    protected $id;

    /** @Column(type="string") */
    protected $username;

    /** @Column(type="string") */
    protected $oauth_provider;

    /** @Column(type="string") */
    protected $oauth_uid;

    /** @Column(type="string") */
    protected $oauth_token;

    /** @Column(type="string") */
    protected $oauth_secret;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getOAuthProvider()
    {
        return $this->oauth_provider;
    }

    /**
     * @return mixed
     */
    public function getOAuthUid()
    {
        return $this->oauth_uid;
    }

    /**
     * @return mixed
     */
    public function getOAuthToken()
    {
        return $this->oauth_token;
    }

    /**
     * @return mixed
     */
    public function getOAuthSecret()
    {
        return $this->oauth_secret;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param $oauth_provider
     */
    public function setOAuthProvider($oauth_provider)
    {
        $this->oauth_provider = $oauth_provider;
    }

    /**
     * @param $oauth_uid
     */
    public function setOAuthUid($oauth_uid)
    {
        $this->oauth_uid = $oauth_uid;
    }

    /**
     * @param $oauth_token
     */
    public function setOAuthToken($oauth_token)
    {
        $this->oauth_token = $oauth_token;
    }

    /**
     * @param $oauth_secret
     */
    public function setOAuthSecret($oauth_secret)
    {
        $this->oauth_secret = $oauth_secret;
    }
}