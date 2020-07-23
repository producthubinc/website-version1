<?php
session_start();

require "mongo.php";

require "user.php";

require "sendmail.php";

// UTILITEST FUNCTIONS
//TBD: MOVE TO SEPARATE FILE
//////////////////////////////
#SETTING UP REQUEST TYPE
$request = null;
if (isset($_GET["request"]))
    $request = $_GET["request"];
else if (isset($_POST["request"]))
    $request = $_POST["request"];
else {
    $response = new Response(ResponseType::ERROR, "", "Undefined Request");
    die($response->GetResponse());
}

if ($request == "subscribe") {
    $email = $_GET["email"];
    $email = strtolower($email);

    $file = "../data/mailing-list.csv";

    //TBD: check whether the file previously exists or not
    $filesize = filesize($file);

    if ($filesize) {
        $handle = fopen($file, "r");
        $content = fread($handle, $filesize);

        if (strpos($content, $email) !== false) {
            $response = new Response(ResponseType::ERROR, "", "You are already subscribed!");
            die($response->GetResponse());
        }
    }

    writeToFile($file, $email . "\n", "a+");
    $response = new Response(ResponseType::SUCCESS, "", "You have been subscribed to our mailing list!");
    echo $response->GetResponse();
} else if ($request == "collaborate") {
    $email = $_GET["CollabEmail"];
    $email = strtolower($email);

    $name = $_GET["Name"];
    $contact = $_GET["Contact"];
    $business = $_GET["BusinessType"];


    $file = "../data/collaborator-list.csv";

    //TBD: check whether the file previously exists or not
    $filesize = filesize($file);

    if ($filesize) {
        $handle = fopen($file, "r");
        $content = fread($handle, $filesize);
        fclose($handle);
        if (strpos($content, $email) !== false) {
            $response = new Response(ResponseType::ERROR, "", "You are already registered as Collaborator!");
            die($response->GetResponse());
        }
    }
    $data = $email . "," . $name . "," . $contact . "," . $business . "\n";
    writeToFile($file, $data, "a+");
    $response = new Response(ResponseType::SUCCESS, "", "Thank you for collaborating with us.");
    echo $response->GetResponse();
} else if ($request == "login") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $response = Login($username, $password);
    echo $response->GetResponse();
} else if ($request == "signup") {
    $response = Signup($_POST);
    echo $response->GetResponse();
} else if ($request == "validateuser") {
    if (isset($_SESSION["user"])) {
        $response = new Response(ResponseType::SUCCESS, json_encode($_SESSION["user"]), "");
        echo $response->GetResponse();
    } else {
        $response = new Response(ResponseType::ERROR, "", "");
        echo $response->GetResponse();
    }
} else if ($request == "logout") {
    $response = Logout();
    echo $response->GetResponse();
} else if ($request == "placeorder") {
    $fileName = "Orders.json";
    $orders = json_decode(file_get_contents($fileName));
    $id = count($orders) + 1;
    $orderId = sprintf("PH%d", (1000 + $id));
    $path = "../uploads/" . strval($orderId) . $_FILES['file']["name"];
    $_POST['File'] = $path;
    
    $user = json_decode(json_encode($_SESSION["user"]), true);
    $_POST['Email'] = $user['Email'];
    $_POST['Contact'] = $user['Contact'];
    $_POST['OrderId'] = $orderId;
    unset($_POST["request"]);
    
    array_push($orders, $_POST);
    if(!move_uploaded_file($_FILES['file']['tmp_name'], $path))
    {
        $response = new Response(ResponseType::ERROR, "", "Unable to upload file");
        die($response->GetResponse());
    }
    file_put_contents($fileName, json_encode($orders));
    $response = new Response(ResponseType::SUCCESS, "", "Order Placed");
    
    SendMail($user['FirstName'],$orderId,$_POST['Quantity'],$_POST['Amount'],$_POST['PaymentMode'],$user['Email'], $_POST['Address']);
    die($response->GetResponse());
}
else if($request == "getaddress")
{
    $fileName = "Orders.json";
    $orders = json_decode(file_get_contents($fileName));
    $user = $_SESSION["user"];

    foreach($orders as $order)
    {
        if($order->Email == $user->Email)
        {
            $response = new Response(ResponseType::SUCCESS, $order->Address, "");
            die($response->GetResponse());
        }
    }
}

?>
