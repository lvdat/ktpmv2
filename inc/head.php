<?
// include file config server
include $_SERVER['DOCUMENT_ROOT'].'/inc/all.php';

//Xử lý cookie
if(isset($_COOKIE['path']) && !isset($_SESSION['logged'])){
    if(getcookie($_COOKIE['path']) == "0"){
        setcookie("path", "", time() - 60, "/","", 0);
        echo '<script>alert("Cookie của bạn không hợp lệ, vui lòng đăng nhập lại");</script>';
        header("Location: /dangnhap");
    }else{
        $_SESSION['logged'] = getcookie($_COOKIE['path']);
    }
}elseif(isset($_SESSION['logged']) && !isset($_COOKIE['path'])){
    $mssv = $_SESSION['logged'];
    $path = str_random(8).'_'.str_random(4).'_'.str_random(5).'_'.str_random(100);
    setrawcookie('path', $path, time() + 864000);
    $sql = "INSERT INTO cookie (path, mssv) VALUES ('$path', '$mssv')";
    $conn->query($sql);
}
if(login()){
    define('MSSV', $_SESSION['logged']);
    updateexp($_SESSION['logged'], 1);
    $mssv = $_SESSION['logged'];
    $time = time();
    $sql = "UPDATE dssv SET lastlogin = $time WHERE mssv = '$mssv'";
    $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="vi">
    <head>
        <title><?if(isset($title)){echo $title;}else{echo 'Hệ thống thông tin cho KTPM 04';}?></title>
        <!-- Meta area -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Stylesheet -->
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/asset/css/main.css?v=<?=time()?>">
        <link href="/fontawesome/css/all.css" rel="stylesheet">
        <link href="/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

        <!-- Javascript -->
        <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/asset/js/jquery.min.js"></script>
        <script type="text/javascript">
            (function(t,n,e){"use strict";function i(n,e){this.element=n,this.options=t.extend({},o,e),this._defaults=o,this._name=a,this.init()}var a="pusher",o={watch:"a",initialPath:n.location.pathname,before:function(t){t();$("#overlay").fadeIn(200);},handler:function(){},after:function(){$("html, body").animate({ scrollTop: 0 }, "slow");},fail:function(){n.alert("Failed to load "+this.state.path)},onStateCreation:function(){}};i.prototype={init:function(){var e=this;if(history.pushState){var i=r({path:e.options.initialPath},e.options.onStateCreation);history.replaceState(i,null,i.path),t(e.element).on("click",e.options.watch,function(n){n.preventDefault();var i=r({path:t(this).attr("href"),elem:t(this)},e.options.onStateCreation);s(e,i,!0)}),n.addEventListener("popstate",function(t){s(e,t.state)})}}};var r=function(t,n){var e={};return t=t||{},e.path=t.path,e.time=(new Date).getTime(),n&&n(e,t.elem),e},s=function(n,e,i){if(e){var a={state:e,get:function(t){return u(a.res,t)},updateText:function(n){var e=t(n);this.get(n).each(function(n){var i=t(this).text();e.eq(n).text(i)})},updateHtml:function(n){var e=t(n);this.get(n).each(function(n){var i=t(this).contents();e.eq(n).html(i)})}},o=function(){t.ajax({type:"GET",url:e.path}).done(function(t){a.res=t,i&&history.pushState(e,null,e.path),n.options.handler.apply(a)}).fail(function(){n.options.fail.apply(a)}).always(function(){n.options.after.apply(a)})};n.options.before.apply(a,[o])}},u=function(n,e){var i=t("<root>").html(n),a=i.find(e);return a};t.fn[a]=function(n){t.data(e,"plugin_"+a)||t.data(e,"plugin_"+a,new i(this,n))}})(jQuery,window,document);
            $(document).pusher({
                handler: function() {
                    this.updateHtml("#maintxt");
                    $("#overlay").fadeOut(200);
                }
            });
        </script>
        <? if(isset($editor)): ?>
        <link rel="stylesheet" href="/quill/quill.snow.css">
        <script type="text/javascript" src="/quill/quill.min.js"></script>
        <? endif ?>
    </head>
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <body onload="time()">
    <div id="maintxt">
    <!-- nav -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/" title="Trang chủ">
                <img src="/asset/image/logo.png" alt="" width="30" class="d-inline-block align-top">
                KTPM04
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/" title="Trang chủ"><i class="fas fa-home"></i> Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a target="_blank" class="nav-link" style="cursor: pointer" onclick="codetrain()" title="CodeTrain - Luyện lập trình trực tuyến"><i class="fas fa-code"></i> Luyện lập trình</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/chat" title="Phòng trò chuyện"><i class="fas fa-comments"></i> Phòng trò chuyện</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/lvdat/ktpmv2" title="Mã nguồn web trên Github"><i class="fab fa-github"></i> Github</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <? if(login()) :?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?=getsv(MSSV)['avatar']?>" alt="" width="25" class="d-inline-block align-top" style="border: 1px solid #ab1170;border-radius: 50%">
                            <?=getsv(MSSV)['name'].' '.MSSV?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <? if(getsv(MSSV)['level'] > 0): ?>
                                <li><a class="dropdown-item" title="Quản lí" href="/admin"><i class="fas fa-user-shield"></i> Admin Panel</a></li>
                            <? endif ?>
                            <li><a class="dropdown-item" href="/profile/edit" title="Cài đặt tài khoản"><i class="fas fa-cog"></i> Cài đặt tài khoản</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout" title="Đăng xuất khỏi hệ thống"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                        </ul>
                    </li>
                <? else: ?>
                    <li class="nav-item"><a onclick="dangnhap()" title="Đăng nhập hệ thống" class="nav-link"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a></li>
                <? endif ?>
            </ul>
            </div>
        </div>
        <script>function codetrain(){
            window.open("https://codetrain.co", "_blank");
        }
        function dangnhap(){
            window.location = "/dangnhap";
        }</script>
    </nav>
    <!-- end nav -->
    <div class="container-md">
        <div class="row d-flex justify-content-center" id="row">
            <div class="col-md-3">
                <div class="sticky">
                <div class="card mb-2">
                    <div class="card-body text-center">
                        <b>Tuần <?=getoption('tuan')?></b> | <?=date("d/m/Y | H:i:s")?>
                    </div>
                </div>
                <div class="d-none d-md-block">
                    <div class="card mb-2">
                        <div class="card-header"><i class="fas fa-cogs"></i> Hệ thống</div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-map-marker-alt"></i> IP: <?=getip()?></li>
                                <li class="list-group-item"><i class="fas fa-eye"></i> Lượt xem trang: <?
                                    $CountFile = $_SERVER['DOCUMENT_ROOT']."/index.log";
                                    $CF = fopen ($CountFile, "r");
                                    $Views = fread ($CF, filesize ($CountFile));
                                    fclose ($CF);
                                    $Views++; 
                                    $CF = fopen ($CountFile, "w");
                                    fwrite ($CF, $Views); 
                                    fclose ($CF); 
                                    echo ($Views);
                                    ?></li>
                                <?php
                                    $time = microtime();
                                    $time = explode(' ', $time);
                                    $time = $time[1] + $time[0];
                                    $finish = $time;
                                    $total_time = round(($finish - $start)*100000, 2);
                                    echo '<li class="list-group-item"><i class="fas fa-clock"></i> Thời gian load trang: '.$total_time.' ms.</li>';
                                ?>
                                <li class="list-group-item"><i class="fas fa-code-branch"></i> Version: <?=VERSION?> </li>
                            </ul>
                    </div>
                    <div id="head_addon"></div>
                </div>
            </div>
            </div>
            <div class="col-md-6">