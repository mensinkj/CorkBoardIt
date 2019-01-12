<?php
if (!$_SESSION[USER_SESSION_VAR]) {
    header("location:index.php");
    exit();
}

$title = "CorkBoardIt - Home";
$description = "Welcome to the CorkBoardIt Homepage!.";
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
            <li class="nav-item active">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
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
        <div class="welcomeTxt">Welcome, XXXXXXX!</div>
        <div class="line"></div>
        <div>
            <div>
                <p><strong>Recent CorkBoard Updates</strong></p>
            </div>
            <div>
                <div>
                    <p class="UpdateCardTopText">Pools</p>
                    <p class="UpdateCardBottomText">Updated by XX XX on XXXX at XXXX</p>
                </div>
                <div>
                    <p class="UpdateCardTopText">Pools</p>
                    <p class="UpdateCardBottomText">Updated by XX XX on XXXX at XXXX</p>
                </div>
            </div>
        </div>
        <div>
            <div>
                <p><strong>My CorkBoards</strong></p>&nbsp;&nbsp;&nbsp;&nbsp;<span>Add New</span>&nbsp;<img src="/img/plus.png"/>
            </div>
            <div>
                <div>
                    <p class="UpdateCardTopText">Cats and their Antics</p>
                    <div>
                        <div>
                            <svg width="51px" height="36px" viewBox="0 0 51 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <defs>
                                    <filter x="-4.6%" y="-16.9%" width="109.1%" height="133.8%" filterUnits="objectBoundingBox" id="filter-1">
                                        <feOffset dx="0" dy="2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                                        <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                                        <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" type="matrix" in="shadowBlurOuter1" result="shadowMatrixOuter1"></feColorMatrix>
                                        <feMerge>
                                            <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                                            <feMergeNode in="SourceGraphic"></feMergeNode>
                                        </feMerge>
                                    </filter>
                                    <filter x="-30.8%" y="-54.5%" width="161.5%" height="209.1%" filterUnits="objectBoundingBox" id="filter-2">
                                        <feOffset dx="0" dy="2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                                        <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                                        <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" type="matrix" in="shadowBlurOuter1" result="shadowMatrixOuter1"></feColorMatrix>
                                        <feMerge>
                                            <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                                            <feMergeNode in="SourceGraphic"></feMergeNode>
                                        </feMerge>
                                    </filter>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Home-Page" transform="translate(-576.000000, -318.000000)">
                                        <g id="Group-2-Copy-2" filter="url(#filter-1)" transform="translate(566.000000, 282.000000)">
                                            <g id="label-info" filter="url(#filter-2)" transform="translate(16.000000, 39.000000)">
                                                <rect id="BG" fill="#1B2E75" x="0" y="0" width="39" height="22" rx="11"></rect>
                                                <text id="3:7:3:7" font-family="HelveticaNeue-Bold, Helvetica Neue" font-size="12" font-weight="bold" fill="#FFFFFF">
                                                    <tspan x="12" y="15">22</tspan>
                                                </text>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <p class="UpdateCardBottomText">Pushpins</p>
                    </div>
                </div>
                <div>
                    <p class="UpdateCardTopText">Pools</p>
                    <div>
                        <svg width="51px" height="36px" viewBox="0 0 51 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs>
                                <filter x="-4.6%" y="-16.9%" width="109.1%" height="133.8%" filterUnits="objectBoundingBox" id="filter-1">
                                    <feOffset dx="0" dy="2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                                    <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                                    <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" type="matrix" in="shadowBlurOuter1" result="shadowMatrixOuter1"></feColorMatrix>
                                    <feMerge>
                                        <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                                        <feMergeNode in="SourceGraphic"></feMergeNode>
                                    </feMerge>
                                </filter>
                                <filter x="-30.8%" y="-54.5%" width="161.5%" height="209.1%" filterUnits="objectBoundingBox" id="filter-2">
                                    <feOffset dx="0" dy="2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                                    <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                                    <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" type="matrix" in="shadowBlurOuter1" result="shadowMatrixOuter1"></feColorMatrix>
                                    <feMerge>
                                        <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                                        <feMergeNode in="SourceGraphic"></feMergeNode>
                                    </feMerge>
                                </filter>
                            </defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Home-Page" transform="translate(-576.000000, -318.000000)">
                                    <g id="Group-2-Copy-2" filter="url(#filter-1)" transform="translate(566.000000, 282.000000)">
                                        <g id="label-info" filter="url(#filter-2)" transform="translate(16.000000, 39.000000)">
                                            <rect id="BG" fill="#1B2E75" x="0" y="0" width="39" height="22" rx="11"></rect>
                                            <text id="3:7:3:7" font-family="HelveticaNeue-Bold, Helvetica Neue" font-size="12" font-weight="bold" fill="#FFFFFF">
                                                <tspan x="12" y="15">8</tspan>
                                            </text>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <p class="UpdateCardBottomText">PushPins</p>
                </div>
            </div>
        </div>

    <div></div>
    <div class="line"></div>
    <p><strong>Search For PushPins</strong></p>
    <form class="form-group Search" action="p_pushpinSearch.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Search Description, Tags and CorkBoard Category" name="pushpinSearch" required/>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    </div>
    </body>
</html>

