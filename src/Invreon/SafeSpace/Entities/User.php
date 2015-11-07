<?php
namespace Invreon\SafeSpace\Entities;

// src/Invreon/SafeSpace/Entities/User.php
/**
 * @Entity
 * @Table(name="user")
 */
class User
{
    /** @Id @Column(type="integer") @GeneratedValue **/
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
}