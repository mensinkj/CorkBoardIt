<?php
// Verify Login
if (!$_SESSION[USER_SESSION_VAR]) {
    header("location:index.php");
    exit();
}
include_once "utility/config.php";
include_once "utility/dbclass.php";
include_once "utility/functions.php";
include "header.php";

// Get Params
$pushpinID = $_GET['pushpinID'];

//Get Data for View Pushpin page according to pushpin Id in URL #############
##############################################################################
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
$PPresult = mysqli_query($db, "SELECT p.pushpinID, p.pinned_date, p.description, p.host, p.path, p.protocol, c.corkboardID, c.title,
c.userID, u.first_name, u.last_name, (SELECT GROUP_CONCAT(tag) FROM Tag WHERE pushpinID = " . $pushpinID . " ) as Tags  FROM PushPin p
INNER JOIN Corkboard c ON c.corkboardID = p.corkboardID
INNER JOIN `User` u ON u.userID = c.userID WHERE pushpinID = " . $pushpinID . ";");
$PPdataSet = mysqli_fetch_row($PPresult);
// Get list of users that like this pushpin
$LikeListresult = mysqli_query($db, "SELECT Likes.userID, u.first_name, u.last_name FROM Likes
INNER JOIN  `User` u ON u.userID = Likes.userID WHERE Likes.pushpinID = " . $pushpinID . ";");
$LLString = "";
$counter = 0;
$numResults = mysqli_num_rows($LikeListresult);
while($row = mysqli_fetch_row($LikeListresult)){
    if($numResults > 1){
        if(++$counter == $numResults){
            $LLString .= "and " . $row[1] . " " . $row[2];
        }else{
            $LLString .= $row[1] . " " . $row[2] . ", ";
        }
    }else{
        $LLString .= $row[1] . " " . $row[2];
    }
    
}
// Get the list of Tags for this pushpin
$Tagresult = mysqli_query($db, "SELECT tag FROM Tag WHERE pushpinID = " . $pushpinID . ";");

//Get Comments for ths pushpin
$Commentresult = mysqli_query($db, "SELECT c.commentID, c.date_added, c.text, u.first_name, u.last_name FROM Comments c 
    INNER JOIN `User` u ON u.userID = c.userID WHERE c.pushpinID = " . $pushpinID . " ORDER BY c.date_added DESC");

mysqli_close($db);
//#########################################################################################################################
#############################################################################################################################


//initalize some variables############
$title = "CorkBoardIt - ViewPushPin";
$description = "View Pushpin Details";
$pinned_date = $PPdataSet[1];
$PPdescription = $PPdataSet[2];
$hostpath = $PPdataSet[3];
$path = $PPdataSet[4];
$protocol = $PPdataSet[5];
$corkboardID = $PPdataSet[6];
$corkboardtitle = $PPdataSet[7];
$creatorID = $PPdataSet[8];
$first_name = $PPdataSet[9];
$last_name = $PPdataSet[10];
$imgsrc = $protocol . "://" . $hostpath . $path;
$Comment = $_POST['AddComment'];
$Follow = $_POST['Follow'];
$Unfollow = $_POST['Unfollow'];
$Like = $_POST['Like'];
$Unlike = $_POST['Unlike'];
$Following = FALSE;
$LikePushPin = FALSE;

### Check for Following and Likes on Board ####################################################################
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
$FollowsResult = mysqli_query($db, "SELECT followeeID FROM Follows WHERE followerID = ".$_SESSION[USER_SESSION_VAR]." and followeeID = ".$creatorID.";");
$numResults = mysqli_num_rows($FollowsResult);
if($numResults > 0){
    $Following = TRUE;
}

$LikesResult = mysqli_query($db, "SELECT pushpinID FROM Likes WHERE userID = ".$_SESSION[USER_SESSION_VAR]." and pushpinID = ".$pushpinID.";");
$numResults = mysqli_num_rows($LikesResult);
if($numResults > 0){
    $LikePushPin = TRUE;
}

mysqli_close($db);
//HANDLE BUTTON CLICK EVENTS #######################################################################################
#####################################################################################################################
// Create a Comment on Pushpin
if($Comment){
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
    $sql = "INSERT INTO Comments (date_added, pushpinID, userID, text) VALUES (NOW(),".$pushpinID.", ".$_SESSION[USER_SESSION_VAR].", '".$_POST['commentText']."');";
    mysqli_query($db,$sql);
    mysqli_close($db);
    header("location: viewPushPin?pushpinID=" . $pushpinID);
    exit();
}
//Follow Pushpin Creator
if($Follow){
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
    $sql = "INSERT INTO Follows (followerID,followeeID) VALUES (".$_SESSION[USER_SESSION_VAR].",".$creatorID.");";
    mysqli_query($db,$sql);
    mysqli_close($db);
    $Following = TRUE;
    header("location: viewPushPin?pushpinID=" . $pushpinID);
    exit();
}
//Unfollow Pushpin Creator
if($Unfollow){
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
    $sql = "Delete FROM Follows WHERE followerID = ".$_SESSION[USER_SESSION_VAR]." and followeeID = ".$creatorID.";";
    mysqli_query($db,$sql);
    mysqli_close($db);
    header("location: viewPushPin?pushpinID=" . $pushpinID);
    exit();
}
//Like Pushpin
if($Like){
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
    $sql = "INSERT INTO Likes (pushpinID, userID) VALUES (".$pushpinID.", ".$_SESSION[USER_SESSION_VAR].");";
    mysqli_query($db,$sql);
    mysqli_close($db);
    header("location: viewPushPin?pushpinID=" . $pushpinID);
    exit();
}
//Unlike PushPin
if($Unlike){
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
    $sql = "Delete From Likes WHERE pushpinID = ".$pushpinID." and userID = ".$_SESSION[USER_SESSION_VAR].";";
    mysqli_query($db,$sql);
    mysqli_close($db);
    header("location: viewPushPin?pushpinID=" . $pushpinID);
    exit();
}
//#########################################################################################################################
##############################################################################################################################
?>

<style>
.navbar {
    background-color: #0B2E75;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, .5);
}
.nav-link {
    opacity: 0.5;
    color:white;
}
.navbar-brand, .nav-item.active > .nav-link {
    color: white;
    opacity: 1;
 }

.btn-primary,
.btn-primary:hover,
.btn-primary:active,
.btn-primary:visited,
.btn-primary:focus {
    background-color: #1B2E75;
    border-color: #1B2E75;
}
#container {
    margin-top: 30px;
    padding: 20px 50px;
}
form.Search {
    width: 430px;
}
.logo {
    float: right;
    padding-right: 50px;
    margin-top: -15px;
}
.welcomeTxt{
    font-family: OpenSans-Regular;
font-size: 22px;
color: #000000;
letter-spacing: 0;
text-align: left;
margin-bottom: -15px;
}
.line {
    border: 1px solid #979797;
    margin: 30px 0 20px 0;
}
.PushPinPic{
    max-width:50%;
    max-height:500px;
    width:auto;
    height:auto;
}
</style>

<body>
 <header>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="/">CorkBoardIt</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/corkboardStats">CorkBoard Stats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/PopularSites">Popular Sites</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/popularTags">Popular Tags</a>
            </li>
            </ul>
            <form action="p_login_manager.php" method="post" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="hidden" name="type" value="logout">
                <button class="btn btn-light my-2 my-sm-0" type="submit">Logout</button>
            </form>
        </div>
    </nav>
 </header>
    <?php showMessage();?>
    <div id="container">
        <img class="logo" src="/img/logo.png" alt="CorkBoardIt logo" title="corkboardIt logo"/>  
        <div class="welcomeTxt">View PushPin</div>
        <div class="line"></div>
        <div class="row">
            <img class="PushPinPic col-sm-6" src="<?php echo $imgsrc?>">
            <div class="col-sm-6">
                <?php if($Following == FALSE){
                    echo "<form method=\"POST\">
                        <strong>".$first_name." ".$last_name."</strong>
                        <button style=\"margin-left:10px;\" type=\"submit\" name=\"Follow\" value=\"Follow\" class=\"btn btn-info btn-sm\">Follow</button>
                    </form>";
                }else{
                    echo "<form method=\"POST\">
                        <strong>".$first_name." ".$last_name."</strong>
                        <button style=\"margin-left:10px;\" type=\"submit\" name=\"Unfollow\" value=\"Unfollow\" class=\"btn btn-info btn-sm\">Unfollow</button>
                    </form>"; 
                }
                if($LikePushPin == FALSE){
                    echo "<form method=\"POST\">
                        <p>Pinned ".substr($pinned_date,0,10)." at ".substr($pinned_date,11)." on 
                        <a href=\"viewCorkBoard?corkboardID=".$corkboardID."\">".$corkboardtitle."</a>
                        <button style=\"margin-left:10px;\" type=\"submit\" name=\"Like\" value=\"Like\" class=\"btn btn-success btn-sm\">Like</button></p>
                    </form>";
                }else{
                    echo "<form method=\"POST\">
                        <p>Pinned ".substr($pinned_date,0,10)." at ".substr($pinned_date,11)." on 
                        <a href=\"viewCorkBoard?corkboardID=".$corkboardID."\">".$corkboardtitle."</a>
                        <button style=\"margin-left:10px;\" type=\"submit\" name=\"Unlike\" value=\"Unlike\" class=\"btn btn-success btn-sm\">Unlike</button></p>
                    </form>"; 
                }?>
                <strong>Image Source:</strong>
                <p><?php echo $hostpath?></p>
                <strong>Description</strong>
                <p><?php echo $PPdescription?></p>
                <strong>Tags:</strong>
                <div class="row" style="margin-left:10px" id="taglist">
                    <?php while($row = $Tagresult->fetch_assoc()){
                            echo "<p class='badge badge-primary' style='margin-right:10px'>" . $row['tag'] . "</p>";
                        }?>
                </div>
                <strong>Likes</strong>
                <p><?php echo $LLString?></p>
            </div>
        </div>
        <div >
            <strong>Comments:</strong>
            <form method="post" class="row">
                <textarea name="commentText" class="col-sm-5" rows="2" cols="50" placeholder="Add Comment" maxlength="200"></textarea>
                <button type="submit" name="AddComment" value="AddComment" style="margin-left:10px;" class="col-sm-1 btn btn-primary">Post</button>
            </form>
            <div id="commentlist" style="margin-top:20px;width:100%;">
                <?php while($row = $Commentresult->fetch_assoc()){
                    echo "<p><img style='width:25px;height:25px;margin-right:10px;' src='data:image/png;base64,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'>";
                    echo "<strong>" . $row['first_name'] . " " . $row['last_name'] . " </strong><span style='font-size:8pt;'>" . $row['date_added'] . "</span></p>";
                    echo "<p style='margin-left:20px;'>" .$row['text'] . "</p>";
                    echo "<div class='line' style='width:50%;'></div>";
                }?>
            </div>
        </div>
    </div>
    </body>
</html>

