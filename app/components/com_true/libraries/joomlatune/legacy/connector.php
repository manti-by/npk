<?php
class JTConnector
{
    function connect($path){
        require_once($path.DS.'input.php');
        require_once($path.DS.'route.php');
        require_once($path.DS.'redirect.php');
        require_once($path.DS.'db.php');
        require_once($path.DS.'jsconnect.php');
    }
}
?>