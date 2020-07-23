
<?php

function writeToFile($filePath,$content,$mode)
{
    $handle = fopen($filePath, $mode);
    fwrite($handle, $content);
    fclose($handle);
}

function readFileContent($filePath)
{
    $handle = fopen($filePath, "r");
    $content = fread($handle);
    fclose($handle);
    return $content;
}

function Logout()
{
    $_SESSION = array();
    session_destroy();
    return new Response(ResponseType::SUCCESS,"","You have been logged out.");
}

function Login($username,$password)
{
    $fileName = "Users.json";
    $users = json_decode(file_get_contents($fileName));
    $user = null;
    foreach ($users as $item) 
    {   
        if (($item->Email == $username || $item->Contact == $username ) && $item->Password == $password) 
        {
            $user = $item;
            break;
        }
    }
    if($user)
    {
        $_SESSION["user"] = $user;
        return new Response(ResponseType::SUCCESS,"","You are now logged in");
    }
    return new Response(ResponseType::ERROR,"","Login credentials incorrect");
    // $dbname = "producthub";
    // $collname = "users";
    // $Mongo = new MongoClient($dbname);
    // $Mongo->SelectCollection($collname);

    // $filter = ["Email"=>$username,"Password"=>$password];
    // $options = [];

    // $res = $Mongo->Query($filter,$options);
    // $documents = json_decode($res->GetResponse())->Content;
    // if(count($documents)==1)
    // {
    //     $doc = $documents[0];
    //     $_SESSION["user"] = $doc;
    //     return new Response(ResponseType::SUCCESS,"","You are now Logged In");
    // }
    // return new Response(ResponseType::ERROR,"","Login Credentials Incorrect");


}



function Signup($UserInfo)
{
    $email = $UserInfo["Email"];
    $contact = $UserInfo["Contact"];
    $fileName = "Users.json";
    $users = json_decode(file_get_contents($fileName));
    foreach ($users as $item) 
    {
        if ($item->Email == $email || $item->Contact == $contact) 
        {
            return new Response(ResponseType::ERROR,"","User already registered.");
        }
    }

    unset($UserInfo["request"]);
    $user = $UserInfo;
    array_push($users, $user);
    file_put_contents($fileName, json_encode($users));
    $_SESSION["user"] = $user;
    return new Response(ResponseType::SUCCESS,"","User registered successfully.");
        
    // $dbname = "producthub";
    // $collname = "users";
    // $Mongo = new MongoClient($dbname);
    // $Mongo->SelectCollection($collname);

    // $containsEmail = true;
    // $containsContact = true;
    // $response = json_decode($Mongo->Contains("Email",$email)->GetResponse());

    // if($response->RCode == ResponseType::SUCCESS)
    // {
    //     $containsEmail = $response->Content;
    // }
    // else
    //     return new Response(ResponseType::ERROR,"","Database Read Error");

    // $response = json_decode($Mongo->Contains("Contact",$contact)->GetResponse());
    
    // if($response->RCode == ResponseType::SUCCESS)
    // {
    //     $containsEmail = $response->Content;
    // }
    // else
    //     return new Response(ResponseType::ERROR,"","Database Read Error");

    // if($containsEmail=="false" && $containsContact == "false")
    // {
    //     $response = json_decode($Mongo->WriteOne($UserInfo)); 
    //     if($response->RCode == ResponseType::SUCCESS)
    //     {
    //         return new Response(ResponseType::SUCCESS,"","User Registered!");       
    //     }
    // }
    // else
    //     return new Response(ResponseType::ERROR,"","Already Registered");   
}


?>