<?php

class dbadapter
{

    public $conn = null;


    function __construct(){
        date_default_timezone_set("America/Boise");
        $this-> conn = mysqli_connect("localhost","root","94d548bb171","researchdb");


    }
    function clear (){

    }
    function getconnection()
    {
        return $this->conn;
    }
    function __destruct(){
        $this->clear ();
    }
// returns array of grades from the databasae
    function createsession ($gradeid){
        $uid = $this->guid();
        $now = date('Y-m-d H:i:s');
        $id = -1;
        $query = "INSERT INTO `session` (`id`, `guid`, `gradeid`,`datevisited`)
	values (null,'$uid','$gradeid','$now');";
        if ($this->execute ($query))
        {

            $query =  "SELECT * FROM `session` WHERE guid = '$uid';";
            $result = $this->conn->query ($query);
            while ($row = $result->fetch_assoc())
            {
                $id = $row['id'];

            }
        }
        return $id;
    }
    function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }
      function clickedlink ($sessionid,$url,$searchid, $position)
    {
        $now = date('Y-m-d H:i:s');
        $query  = "insert into `searchlinks` (`sessionid`,`searchid`,`linkclicked`,`timeclicked`, `position`
	) values ('$sessionid','$searchid','$url','$now', $position)";
        if ($this->conn->query ($query)){
            return true;
        }
        return false;
    }
    function storesearch ($searchquery,$sessionid,$issuggestion, $trigger){
        $searchuid = $this->guid();
        $id =-1;
        $now = date('Y-m-d H:i:s');


        $query= "insert into `sessionsearch`
	(`userquery`,`searchuid`,`sessionid`,`timesearched`,`issuggestion`,`trigger`)values
	('$searchquery','$searchuid','$sessionid','$now','$issuggestion', '$trigger'
	)";
        if ($this->execute ($query))
        {
            $query = "select id from `sessionsearch` where searchuid='$searchuid'";
            $result = $this->conn->query ($query);
            while ($row = $result->fetch_assoc())
            {
                $id = $row['id'];
            }
        }
        return $id;
    }

    function getgrades(){
        $query = "SELECT * FROM `grade`;";
        $result = $this->conn->query ($query);
        $grades = array ();

        while ($row = $result->fetch_assoc()){

            $grades[] = array (
                'id' => $row ['id'],
                'grade' => $row ['grade']
            );
        }
        return $grades;
    }
    function execute ($querystring)
    {
        return $this->conn->query($querystring);
    }
}


?>
