<?php

/**
 * Created by PhpStorm.
 * User: chenxc
 * Date: 2016/7/17
 * Time: 18:25
 */
class DAO
{
    private $dbh;
    public function __construct(){
        $dsn = 'mysql:dbname=test;host=127.0.0.1';
        $user = 'root';
        $password = '123456';

        try{
            $this->dbh = new PDO($dsn,$user,$password,[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"]);
        }catch (\Exception $e){
            echo "connection failed:" . $e->getMessage();
        }
    }

    public function findOne($sql){
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $ret = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $ret[0];
    }

    public function findAll($sql){
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $ret = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    public function insert($sql){
        $count = $this->dbh->exec($sql);
    }
}