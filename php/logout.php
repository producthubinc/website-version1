<?php
session_start();
session_unset();

require "mongo.php";
if(session_destroy())
{
    die( (new Response(ResponseType::SUCCESS,"","Logged Out"))->GetResponse() );
}

die( (new Response(ResponseType::SUCCESS,"","Unable to Logout"))->GetResponse());
?>