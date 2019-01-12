<?php

if ($_SESSION[USER_SESSION_VAR]) {
    header("location:home");
    exit();
}

$title = "1CorkBoardIt - Login";
$description = "Welcome to the CorkBoardIt Site!. Please login to start pinning CorkBoards today!";
include "header.php";
?>

<style>
    .btn-primary,
.btn-primary:hover,
.btn-primary:active,
.btn-primary:visited,
.btn-primary:focus {
    background-color: #1B2E75;
    border-color: #1B2E75;
}
.navbar {
    background-color: #0B2E75;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, .5);
}
.navbar-brand {
    color: white;
 }
 form {
     width: 420px;
     margin-top: 20px;
 }
 .im2 {
    margin-top: 20px;
 }
 .column {
    margin-top: 60px;
 }
</style>

<body>
    <header>
        <nav class="navbar">
            <a class="navbar-brand" href="/">CorkBoardIt</a>
        </nav>
    </header>
    <?php showMessage(); ?>
    <div id="container">
      <div class="column">
        <div class="mx-auto">
            <div class="text-center">
                <img src="/img/Logo_Login.png" alt="CorkBoardIt home logo" title="corkboardIt home logo"/>
            </div>
                <form class="form-group mx-auto" action="p_login_manager.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputEmail">Email:</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" required aria-describedby="emailHelp" value="admin@gtonline.com"/>
                    <input type="hidden" name="type" value="login" />
                  </div>
                  <div class="form-group">
                    <label for="inputPin">Pin:</label>
                    <input type="password" class="form-control" id="inputPin" name="pin" value="1234" required/>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            <div class="text-center">
                <img src="img/gt_buzz_logo.png" alt="gt_buzz_logo" title="gt_buzz_logo"/>
            </div>
            <div class="im2 text-center">
                <img src="img/GtechCS.png" alt="GtechCS logo" title="GtechCS logo"/>
            </div>
        </div>
        </div>
    </div>
</body>
</html>

