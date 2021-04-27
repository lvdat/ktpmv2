<?
include $_SERVER['DOCUMENT_ROOT'].'/inc/head.php';
if(!login() || (login() && getsv(MSSV)['level'] == 0)){
    header("Location: /");
}
?>