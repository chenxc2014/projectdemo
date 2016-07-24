<?php

/**
 * Created by PhpStorm.
 * User: chenxc
 * Date: 2016/7/17
 * Time: 21:06
 */
class MysqlDB
{
    private $link;

    public function __construct()
    {
        try{
            $this->link = @mysqli_connect("127.0.0.1","root","123456","test");
        }catch (\Exception $e){
            echo "connection failed:" . $e->getMessage();
        }
    }

    public function findOne($sql){
        $queryResult = @mysqli_query($this->link,$sql);
        if(false === $queryResult){

        }else{
            $row = @mysqli_fetch_row($queryResult);
            if($row){
                return $row[0];
            }
        }
    }

    public function findAll($sql){
        $queryResult = @mysqli_query($this->link,$sql);
        if(false === $queryResult){

        }else{
            $rows = [];
            $row = @mysqli_fetch_row($queryResult);
            while ($row){
                $rows[] = $row;
                $row = @mysqli_fetch_row($queryResult);
            }
            return $rows;
        }
    }
}