<?php

/**
 * Created by PhpStorm.
 * User: chenxc
 * Date: 2016/8/2
 * Time: 19:17
 */
class CredentialSoapHeader
{
    public $Username;
    public $Password;
    public function __construct($username,$password)
    {
        $this->Username = $username;
        $this->Password = $password;
    }
}