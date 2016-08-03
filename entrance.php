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


function executeSoapWsdlSap(){
    try{
        $soap = new SoapClient(null,array('location'=>'http://lidappdb1.cofco.com:50000/dir/wsdl?p=sa/8cf1e89723a930039ef202f3c42e5df0','uri'=>'urn:cofcogroup.com:I_APP:ECC'));
        //ws
        $ns_wsse = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";//WS-Security namespace
        $ns_wsu = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd";//WS-Security namespace

        $userT = new SoapVar('admin', XSD_STRING, NULL, $ns_wsse, NULL, $ns_wsse);
        $passwT = new SoapVar('NnYZe7oD81Kd8QRS4tUMze/2CUs=', XSD_STRING, NULL, $ns_wsse, NULL, $ns_wsse);
        $createdT = new SoapVar(time(), XSD_DATETIME, NULL, $ns_wsu, NULL, $ns_wsu);

        $tmp = new UsernameT1($userT, $passwT, $createdT);
        $uuT = new SoapVar($tmp, SOAP_ENC_OBJECT, NULL, $ns_wsse, 'UsernameToken', $ns_wsse);

        $tmp = new UsernameT2($uuT);
        $userToken = new SoapVar($tmp, SOAP_ENC_OBJECT, NULL, $ns_wsse, 'UsernameToken', $ns_wsse);

        $secHeaderValue=new SoapVar($userToken, SOAP_ENC_OBJECT, NULL, $ns_wsse, 'Security', $ns_wsse);
        $secHeader = new SoapHeader($ns_wsse, 'Security', $secHeaderValue);
        $result2 = $soap->__soapCall("appcall",array(),null,$secHeader);
        echo $result2;
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
}

function executeSoapWsdlSap1(){
    try{
        // wsdl 方式调用
        $url = "http://lidappdb1.cofco.com:50000/dir/wsdl?p=sa/8cf1e89723a930039ef202f3c42e5df0";
        $url ="SI_APP_TO_SAP_S_OUT.wsdl";
        $login = "APP_PI";
        $password ="App2016!qaz";

        $soapClient = new SoapClient($url,
            [
                "login"=>$login,
                "password"=>$password,
                "encoding" =>"utf-8",
                "trace" => true
            ]);


        $method = "appcall";
        $param = ["bsid"=>"SAP","bscode"=>"PS01","boid"=>"","ctime"=>"2016-08-03 17:39:03","nodeid"=>"","reqXML"=>""];
        $result = $soapClient->$method($param);
        $result = json_encode($result);
        $result = json_decode($result,true);
    }
    catch(SoapFault $fault) {
        echo '<br>'.$fault;
    }
}

class UsernameT1 {
    private $Username;
//Name must be  identical to corresponding XML tag in SOAP header
    private $Password;
// Name must be  identical to corresponding XML tag in SOAP header
    private $Created;
    function __construct($username, $password, $created) {
        $this->Username=$username;
        $this->Password=$password;
        $this->Created=$created;
    }
}

class UserNameT2 {
    private $UsernameToken;
//Name must be  identical to corresponding XML tag in SOAP header
    function __construct ($innerVal){
        $this->UsernameToken = $innerVal;
    }
}

executeSoapWsdlSap1();

