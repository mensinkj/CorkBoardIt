<?php
if (!$_SESSION[USER_SESSION_VAR]) {
    header("location:index.php");
    exit();
}
$searchTerm = $_GET['searchWord'];
include_once "utility/config.php";
include_once "utility/dbclass.php";
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_SCHEMA);
$Searchresults = mysqli_query($db, "SELECT p.pushpinID, p.description, c.title, u.first_name, u.last_name FROM PushPin p 
INNER JOIN corkboard c ON c.corkboardID = p.corkboardID INNER JOIN publiccorkboard pubc ON c.corkboardID = pubc.corkboardID 
INNER JOIN user u on u.userID = c.userID WHERE p.description like '%" . $searchTerm . "%' OR c.title like '%" . $searchTerm . "%' OR p.pushpinID in 
(SELECT t.pushpinID FROM Tag t WHERE t.tag like '%" . $searchTerm . "%');");
mysqli_close($db);

$title = "CorkBoardIt - SearchPushPin";
$description = "View Pushpin Search Results";
include "header.php";
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
        <div class="welcomeTxt">View PushPin</div>
        <div class="line"></div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">PushPin Description</th>
                <th scope="col">CorkBoard</th>
                <th scope="col">Owner</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $Searchresults->fetch_assoc()){
                    echo "<tr>";
                    echo "<td><a {$onclick} href='/viewPushPin?pushpinID=" .$row['pushpinID']. "'>" . $row['description'] . "</a></td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['first_name'] . " " . $row[last_name] . "</td>";
                    echo "</tr>";
                }?>
            </tbody>
        </table>
    </div>
    </body>
</html>

