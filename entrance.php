<?php
/**
 * Created by PhpStorm.
 * User: chenxc
 * Date: 2016/7/17
 * Time: 16:14
 */

// 魔术方法 __autoload()
function __autoload($className){
    $classPath="./".$className.'.php';
    if(file_exists($classPath)){
        require_once($classPath);
    }
    else{
        echo 'class file'.$classPath.'not found!';
    }
}

//class libs
//{
//    public static function autoload($className){
//        $classPath="./".$className.'.php';
//        if(file_exists($classPath)){
//            require_once($classPath);
//        }
//        else{
//            echo 'class file'.$classPath.'not found!';
//        }
//    }
//}
//spl_autoload_register("libs::autoload");
//$class = new ClassA();
//
//$sql = "select * from myTable1";
//$dao = new DAO();
//$records = $dao->findAll($sql);
//
//if(isset($records)){
//    foreach($records as $record){
//
//    }
//}
//
//$sql = "insert into myTable1(col2) values('chenxd')";
//$count = $dao->insert($sql);
//
//$sql = "select * from myTable1";
//$mysqlDb = new MysqlDB();
//$records = $mysqlDb->findAll($sql);
//
//$arrData = [
//    [1,2],
//    [3,4]
//];
//$frist = current($arrData);

echo "chenxc111\r\n";

