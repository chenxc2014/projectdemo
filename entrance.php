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


function executeSoapWsdl(){
    try{
        // wsdl 方式调用
        $url = "http://localhost:44854/Service1.asmx?wsdl";
        $soapClient = new SoapClient($url,['encoding'=>'utf-8']);

        $header = new SoapHeader('http://tempuri.org/','CredentialSoapHeader', array('Username'=>'admin','Password'=>'123456'));
        $soapClient->__setSoapHeaders([$header]);

        $method = "MyTest";
        $param = ["name"=>"chenxc"];
        $result = $soapClient->$method($param);
        $response = $method . "Result";
        var_dump($result->$response);
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
}


function executeSoapNonWsdlSoapParam(){
    try{
        // non-wsdl 方式调用
        $url = "http://127.0.0.1:44854/Service1.asmx";
        $ns = "http://tempuri.org/"; // webservie的命名空间，默认是：http://tempuri.org/
        $soapClient = new SoapClient(null,[
            "location"=>$url,
            "uri"=>$ns]);

//        $headerVar = new SoapVar(['Username'=>'admin','Password'=>'123456'],SOAP_ENC_ARRAY,null,$ns,"CredentialSoapHeader",$ns);
//        $header = new SoapHeader('http://tempuri.org/','CredentialSoapHeader',
//            array('Username'=>'admin','Password'=>'123456'),true);
//        $soapClient->__setSoapHeaders($header);

        $method = "MyTest";
        $soapParam = [new SoapParam("chenxc","name")];
        $result = $soapClient->__soapCall(
            $method,
            $soapParam,
            ["soapaction"=> $ns . $method]
        );
        print_r($result);
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
}

function executeSoapNonWsdlSoapVar(){
    try{
        // non-wsdl 方式调用
        $url = "http://127.0.0.1:44854/Service1.asmx";
        $ns = "http://tempuri.org/"; // webservie的命名空间，默认是：http://tempuri.org/
        $soapClient = new SoapClient(null,[
            "location"=>$url,
            "uri"=>$ns,
            "encoding"=>"utf-8",
            'login' => 'fdipzone', // HTTP auth login
            'password' => '123456' // HTTP auth password
            ]);

        $method = "MyTest";

        $credentialSoapHeader = new CredentialSoapHeader("admin","123456");
        $headerVar = new SoapVar($credentialSoapHeader,SOAP_ENC_OBJECT, null, null, "CredentialSoapHeader", $ns);
        $headerVar = ['Username'=>'admin','Password'=>'123456'];
        $header = new SoapHeader($ns,'CredentialSoapHeader', $headerVar);
        $v = $soapClient->__setSoapHeaders([$header]);

        $soapVar =[new SoapVar("chenxc", XSD_STRING, null, null, "name", $ns)];
        $result = $soapClient->__soapCall(
            $method,
            $soapVar,
            ["soapaction"=> $ns . $method]
        );
        print_r($result);
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
}

executeSoapNonWsdlSoapVar();

