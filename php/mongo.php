<?php
class ResponseType
{
    const DEFAULT = -1;
    const ERROR = 0;
    const WARNING = 1;
    const SUCCESS = 2;
}

class Response
{
    private $ResponseType = ResponseType::DEFAULT;
    private $Content = null;
    private $Message = "";

    public function __construct($responseType, $content, $message)
    {
        $this->ResponseType = $responseType;
        $this->Content = $content;
        $this->Message = $message;
    }

    public function GetResponse()
    {
        return json_encode([
            "RCode" => $this->ResponseType,
            "Content" => $this->Content,
            "Info" => $this->Message
        ]);
    }
}

// class MongoClient
// {
//     private $conn = null;
//     private $database = "";
//     private $collection = "";

//     public function __construct(&$dbName)
//     {
//         $this->conn = new \MongoDB\Driver\Manager();
//         $this->database = $dbName;
//     }

//     public function SelectCollection($collectionName)
//     {
//         $this->collection = $collectionName;
//     }

//     public function Query(&$filter, &$options)
//     {
//         if ($this->conn == null)
//             return new Response(ResponseType::ERROR, null, "Unable to connect to DB");
//         if ($this->database == "" || $this->collection == "")
//             return new Response(ResponseType::ERROR, null, "Database or Collection not set!");

//         $query = new MongoDB\Driver\Query($filter, $options);
//         $cursor = $this->conn->executeQuery($this->database . "." . $this->collection, $query);
//         $content = [];     
//         foreach ($cursor as $document) {
//             array_push($content, $document);
//         }
//         return new Response(ResponseType::SUCCESS, $content, "");
//     }

//     public function Contains($key,$value)
//     {
//         $filter = [$key=>$value];
//         $options = [];
//         $res = $this->Query($filter,$options);
//         $res = json_decode($res->GetResponse());
//         if($res->RCode == ResponseType::ERROR)
//         {
//             return (new Response(ResponseType::ERROR,"","Error Reading From Database"));
//         }
//         $documents = $res->Content;
//         $exist = "true";
//         if(count($documents)==0)
//             $exist = "false";
//         return (new Response(ResponseType::SUCCESS,$exist,""));
//     }

//     public function WriteOne($doc)
//     {
//         try {
//             $writer = new MongoDB\Driver\BulkWrite;
//             $writer->insert($doc);
//             $this->conn->executeBulkWrite($this->database . "." . $this->collection, $writer);
//         } catch (MongoDB\Driver\Exception\Exception $e) {
//             return new Response(ResponseType::ERROR, "", $e->getMessage());
//         }
//         return new Response(ResponseType::SUCCESS, "", "1 Document Inserted");
//     }

//     public function WriteAll($docs)
//     {
//         try {
//             $writer = new MongoDB\Driver\BulkWrite;
//             foreach ($docs as $doc) {
//                 $writer->insert($doc);
//             }
//             $this->conn->executeBulkWrite($this->database . "." . $this->collection, $writer);
//         }
//         catch(MongoDB\Driver\Exception\Exception $e)
//         {
//             return new Response(ResponseType::ERROR, "", $e->getMessage());
//         }
        
//         return new Response(ResponseType::SUCCESS, "", count($docs)." Documents Inserted");
//     }

//}
############################
        #Test Code
############################

/*
    ////////////////////////
        READ FROM DB
    ////////////////////////
    $dbname = "producthub";
    $collname = "users";

    $filter = ["username"=>"sparkskapil@gmail.com","password"=>"admin@123"];
    #print_r($filter);
    $options = [];
    $Mongo = new MongoClient($dbname);
    $Mongo->SelectCollection($collname);

    $res = $Mongo->Query($filter,$options);
    print_r(json_decode($res->GetResponse()));
    // foreach ($cursor as $document) {
    //     print_r($document);
    //}
*/
    
/*
    ////////////////////////
#        WRITE ONE TO DB
    ////////////////////////
    $dbname = "producthub";
    $collname = "users";

    $Mongo = new MongoClient($dbname);
    $Mongo->SelectCollection($collname);
    $doc = ["username" => "coderkaps","password"=> "admin@123"];    
    $res = $Mongo->WriteOne($doc);
    print_r(json_decode($res->GetResponse()));
    // foreach ($cursor as $document) {
    //     print_r($document);
    //}
*/

/*
    ////////////////////////
#        WRITE ALL TO DB
    ////////////////////////
    $dbname = "producthub";
    $collname = "users";

    $Mongo = new MongoClient($dbname);
    $Mongo->SelectCollection($collname);
    $doc = ["username" => "coderkaps","password"=> "admin@123"];    
    $docs = [$doc,$doc,$doc];
    $res = $Mongo->WriteAll($docs);
    print_r(json_decode($res->GetResponse()));
    // foreach ($cursor as $document) {
    //     print_r($document);
    //}
*/

    ////////////////////////
#     CONTAINS QUERY TEST
    ////////////////////////

// $dbname = "producthub";
// $collname = "users";

// $Mongo = new MongoClient($dbname);
// $Mongo->SelectCollection($collname);
// $response = ($Mongo->Contains("Contact","7769826757")->GetResponse());
// echo $response;
// print_r( json_decode($response));

?>