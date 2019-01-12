<?php
if (!$_SESSION[USER_SESSION_VAR]) {
    header("location:index.php");
    exit();
}

include_once "utility/config.php";
include_once "utility/dbclass.php";
include "header.php";
//Variables
$corkboardID = $_GET['corkboardID'];
$title = "CorkBoardIt - AddPushPin";
$description = "Add Pushpin to Corkboard";
$AddPushPin = $_POST['AddPushPin'];
$showTagError = FALSE;
$showURLerror = FALSE;
$showURLLengthError = FALSE;
$CreatePushpin = TRUE;

//Get CorkBoard Name from ID
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
$sql = "SELECT title FROM Corkboard WHERE corkboardID = ". $corkboardID .";";
$corkboardresults = mysqli_query($db, $sql);
$corkboardData = mysqli_fetch_row($corkboardresults);
$corkboardTitle = $corkboardData[0];
mysqli_close($db);

//Add pushpin to DB
if($AddPushPin){
    //Validate Tags ####################
    $tags = explode(",",$_POST['TagList']);
    foreach($tags as $tag){
        if(strlen($tag) > 20){
            $CreatePushpin = FALSE;
            $showTagError = TRUE;
        }
    }
    if(substr($_POST['URLText'],0,4) != "http"){
        $CreatePushpin = False;
        $showURLerror = TRUE;
    }
    $url = $_POST['URLText'];
    $host = (parse_url($url, PHP_URL_HOST));
    $path = (parse_url($url, PHP_URL_PATH));
    $proto = (parse_url($url, PHP_URL_SCHEME));
    if((strlen($proto) > 10) Or (strlen($path) > 255) Or (strlen($host) > 50)){
        $CreatePushpin = FALSE;
        $showURLLengthError = TRUE;
    }
    if($CreatePushpin == TRUE){
        //Prep data for insert query
        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
        
        //insert into DB
        $sqlGetPushPinID = "SELECT pushpinID FROM PushPin ORDER BY pushpinID DESC LIMIT 1";
        $sqlInsertPushPin = "INSERT INTO pushpin (pinned_date, corkboardID, description, host, path, protocol) 
        VALUES (NOW(),".$corkboardID.",'".$_POST['DescriptionText']."','".$host."','".$path."','".$proto."');";
        mysqli_query($db,$sqlInsertPushPin);
        //Get recently created pushpin #######################
        $sqlGetPushPinID = "SELECT pushpinID FROM PushPin ORDER BY pushpinID DESC LIMIT 1";
        $pushpinresults = mysqli_query($db, $sqlGetPushPinID);
        $pushpinData = mysqli_fetch_row($pushpinresults);
        $pushpinID = $pushpinData[0];
        //Insert tags in DB
        foreach($tags as $tag){
            $sqlInsertTag = "INSERT INTO Tag (pushpinID, tag) VALUES (".$pushpinID.",'".$tag."');";
            mysqli_query($db,$sqlInsertTag);
        }
        //Update corkboard last_updated column in DB
        $sqlUpdateCorkBoard = "UPDATE Corkboard SET last_updated = NOW() WHERE corkboardID = ".$corkboardID.";";
        mysqli_query($db,$sqlUpdateCorkBoard);
        mysqli_close($db);
        header("location: viewCorkBoard?corkboardID=".$corkboardID);
        exit();
    }
}

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
        <div class="welcomeTxt">Add PushPin</div>
        <div class="line"></div>
        <div>
            <p><strong>Selected CorkBoard:</strong> <?php echo $corkboardTitle?></p>
            <form class="col-md-8" method="post">
                <label><span style="color:red;">*</span>URL</label><br>
                    <?php if($showURLerror == TRUE){echo "<h6 style=\"color:red\">URL must start with http:// or https://</h6>";}?>
                    <?php if($showURLLengthError == TRUE){echo "<h6 style=\"color:red\">URL is too long</h6>";}?>
                <textarea type="url" name="URLText" class="col-sm-5" rows="1" cols="50" maxlength="315" placeholder="https://samplewebsite.picture.jpg" required></textarea><br>
                <label><span style="color:red;">*</span>Description</label><br>
                <textarea required name="DescriptionText" maxlength="200" class="col-sm-8" rows="3" cols="50" placeholder="This statement describes the picture"></textarea><br>
                <label>Tags</label><br>
                    <?php if($showTagError == TRUE){echo "<h6 style=\"color:red\">Tags Must be less than 20 characters</h6>";}?>
                <textarea name="TagList" class="col-sm-5" rows="1" cols="50" placeholder="tag1, tag2, tag3, tag4"></textarea><br><br>
                <button type="submit" name="AddPushPin" value="AddPushPin" class="btn btn-primary">Add</button>
            </form>
        
        </div>
    </div>
    </body>
</html>

