<?php
    $mysqli = new mysqli("sql203.epizy.com:3306", "epiz_32765734", "201475MuuEH2yY", "epiz_32765734_data");
    session_start();

    function idFromUser($nameuser){
        global $mysqli;
        $uid = 0;
        $username = $mysqli->escape_string($nameuser);
        $statement = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result();
        while($row = $result->fetch_assoc()){
            $uid = (int)$row["id"];
        }
        $statement->close();
        return $uid;
    }

    function getUserPic($uid){
        $userpic = (string)$uid;
        if(file_exists("./pfp/".$userpic) !== TRUE){
            $userpic = "default";
        }
        return $userpic;
    }

    $loggedIn = isset($_SESSION['profileuser3']);
?>
