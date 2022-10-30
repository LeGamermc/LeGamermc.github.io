<?php include("global.php");?>
<!DOCTYPE html>
<html data-theme="light">
<head>
    <link rel="stylesheet" type="text/css" href="./css/global.css">
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <title>Watch - KrnlTUBE</title>
</head>
</html>
<?php
include("header.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<div class="topLeft">
    <?php


        $stmt = $mysqli->prepare("SELECT * FROM videos WHERE id = ?");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) exit('No rows');
        while($row = $result->fetch_assoc()) {
            echo '
            <h2>' . $row['videotitle'] . '</h2>
            <iframe id="vid-player" style="border: 0px; overflow: hidden;" src="player/lolplayer.php?id=' . $_GET['id'] . '" height="360px" width="480px"></iframe> <br><br>
                <script>
                    var vid = document.getElementById(\'vid-player\').contentWindow.document.getElementById(\'video-stream\');
                    function hmsToSecondsOnly(str) {
                        var p = str.split(\':\'),
                            s = 0, m = 1;

                        while (p.length > 0) {
                            s += m * parseInt(p.pop(), 10);
                            m *= 60;
                        }

                        return s;
                    }


                    function setTimePlayer(seconds) {
                        var parsedSec = hmsToSecondsOnly(seconds);
                        document.getElementById(\'vid-player\').contentWindow.document.getElementById(\'video-stream\').currentTime = parsedSec;
                    }
                </script>';

            $videoembed = '\
            <iframe id="vid-player" style="border: 0px; overflow: hidden;" src="player/lolplayer.php?id=' . $_GET['id'] . '" height="360px" width="480px"></iframe> <br><br>
            <script>
                var vid = document.getElementById(\'vid-player\').contentWindow.document.getElementById(\'video-stream\');
                function hmsToSecondsOnly(str) {
                    var p = str.split(\':\'),
                        s = 0, m = 1;

                    while (p.length > 0) {
                        s += m * parseInt(p.pop(), 10);
                        m *= 60;
                    }

                    return s;
                }


                function setTimePlayer(seconds) {
                    var parsedSec = hmsToSecondsOnly(seconds);
                    document.getElementById(\'vid-player\').contentWindow.document.getElementById(\'video-stream\').currentTime = parsedSec;
                }
            </script>';
            $videoid = $row['id'];
        }
        ?>

<div class="topRight" style="margin-left: 500px; margin-top: -370px;">
<div class="card gray">
        <?php
            error_reporting(E_ALL & ~E_NOTICE);
            $stmt = $mysqli->prepare("SELECT * FROM videos WHERE id = ?");
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) exit('No rows');
            while($row = $result->fetch_assoc()) {
                echo "Added: " . $row['date'] . "<br>";
                echo "" . $row['views'] . " views<br>";
                echo "" . $row['likes'] . " likes<br>";
                echo "By: " . $row['author'] . "<br><br>";
                echo "<br>description:'" . $row['description'] . "'<br>";
                if($_SESSION["liked".$row["id"]] === false) {
                    echo"<div><a href=\"likevideo2.php?id=".$row["id"]."&u=0\"><img src=\"dislike.png\"></a><h5>please do not spam click the button or you can get ban from the website</h5></div>";
                }
                else{
                    echo"<div><a href=\"likevideo2.php?id=".$row["id"]."&u=1\"><img src=\"like.png\"></a><h5>please do not spam click the button or you can get ban from the website</h5></div>";
                }

            }

        ?>  
    </div>
        <br>
        <div class="card message">     
        <?php
            $stmt = $mysqli->prepare("SELECT * FROM videos WHERE id = ?");
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) exit('No rows');
            while($row = $result->fetch_assoc()) {
                echo "URL <input value=\"http://kerneltube.42web.io/viewvideo.php?id=" . $row["id"] . "\"><br>";
                echo "URL to send in discord <input value=\"http://kerneltube.42web.io/videos/" . $row["filename"] . "\">";
                echo "<br>";
            }

        ?>  
    </div>
        </div>

</div>

        <?php
        mysqli_query($mysqli, "UPDATE videos SET views = views+1 WHERE id = '" . $videoid . "'");
        $stmt->close();
        echo '<hr style="
    margin-top: 50px;
">';
            $stmt = $mysqli->prepare("SELECT * FROM videos WHERE id = ?");
            $stmt->bind_param("s", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) exit('No rows');
            while($row = $result->fetch_assoc()) {
                if ($row['featured'] == '1') {
                    echo "
                <div style=\"
                    color: #000;
                    background-color: var(--card-blue-1);
                    border: 1px solid var(--card-blue-2);
                    padding: 7px 15px;
                    font-size: 12px;
                    border-radius: 7px;
                    text-align: center;
                \"><strong><img src=\"img/star.gif\">This video is featured on the main page!<img src=\"img/star.gif\"></strong></div>
                </div>
                ";
                }
            }

        echo '<h3 style="
    margin-top: 32px;
">Comments &amp; Responses</h3>';
?>


<?php

        if(isset($_POST['submit'])) {
            if(!isset($_SESSION['profileuser3'])) {
                die("Please login to comment.");
            }
            else {
                $stmt = $mysqli->prepare("INSERT INTO comments (tovideoid, author, comment, date) VALUES (?, ?, ?, now())");
                $stmt->bind_param("sss", $_GET['id'], $_SESSION['profileuser3'], $comment);
    
                $comment = str_replace(PHP_EOL, "<br>", htmlspecialchars($_POST['bio']));
    
                $stmt->execute();
                $stmt->close();
                
                echo "<h3>comment added</h3>";
            }
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data"><br>
        Comment: <br><textarea name="bio" rows="4" cols="40" required="required"></textarea><br><br>
        <input type="submit" value="Upload" name="submit">
    </form>
    <hr>
    <?php
        $stmt = $mysqli->prepare("SELECT * FROM comments WHERE tovideoid = ?");
        $stmt->bind_param("s", $_GET['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) echo('No comments.');
        while($row = $result->fetch_assoc()) {
            echo "<div class='commenttitle'>" . $row['author'] . " (" . $row['date'] . ")</div>" . $row['comment'] . "<br><br>";
        }
        $stmt->close();
    ?>
    <hr>
    <?php include("footer.php") ?>
</div>


</html>
    

<?php $mysqli->close();?>
