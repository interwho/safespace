<?php
namespace Invreon\SafeSpace\Entities;

use Doctrine\ORM\Mapping;
/**
 * User
 *
 * @Table(name="users")
 * @Entity
 */
class User
{
    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer", nullable=true)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $username
     *
     * @Column(name="username", type="string", nullable=true)
     */
    protected $username;


    /**
     * @var string $oauth_provider
     *
     * @Column(name="oauth_provider", type="string", nullable=true)
     */
    protected $oauth_provider;


    /**
     * @var string $oauth_uid
     *
     * @Column(name="oauth_uid", type="string", nullable=true)
     */
    protected $oauth_uid;


    /**
     * @var string $oauth_token
     *
     * @Column(name="oauth_token", type="string", nullable=true)
     */
    protected $oauth_token;

    /**
     * @var string $oauth_secret
     *
     * @Column(name="oauth_secret", type="string", nullable=true)
     */
    protected $oauth_secret;

    public function __construct()
    {
        $this->username = "temp";
    }
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