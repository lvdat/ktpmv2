<?
//config db
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'test';
$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_set_charset($conn, 'UTF8');
if(!$conn){
    echo 'Connect Failed';
    exit();
}
function login(){
    global $conn;
    if(isset($_SESSION['logged'])){
        $mssv = $_SESSION['logged'];
        $sql = "SELECT * FROM dssv WHERE mssv = '$mssv'";
        return ($conn->query($sql)->num_rows > 0);
    }else{
        return false;
    }
}
function getsv($mssv){
    global $conn;
    $sql = "SELECT * FROM dssv WHERE mssv = '$mssv'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        $entry = mysqli_fetch_assoc($kq);
            return $entry;
    }else{
        return 0;
    }
}
function updateexp($mssv, $gt){
    global $conn;
    $diem = getsv($mssv)['exp'];
    $diem = $diem + $gt;
    $sql = "UPDATE dssv SET exp = $diem WHERE mssv = '$mssv'";
    $conn->query($sql);
}
function str_random($len) {
$str = '';
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$size = strlen( $chars );
for( $i = 0; $i < $len; $i++ ) {
$str .= $chars[ rand( 0, $size - 1 ) ];
 }
return $str;
}
function gethocphan($id){
    global $conn;
    $sql = "SELECT * FROM hocphan WHERE ID = '$id'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        while ($entry = mysqli_fetch_assoc($kq)){
            return $entry;
        }
    }else{
     return "null";   
    }
}
function getlophp($malop){
    global $conn;
    $sql = "SELECT * FROM lophp WHERE malop = '$malop'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        while ($entry = mysqli_fetch_assoc($kq)){
            return $entry;
        }
    }else{
     return "null";   
    }
}
function gettimehp($malop){
    global $conn;
    $sql = "SELECT * FROM lichlophp WHERE malop = '$malop'";
    $kq = $conn->query($sql);
    $res = '';
    $numrow = $kq->num_rows;
    if($numrow > 0){
        $j = 1;
        while($e = mysqli_fetch_assoc($kq)){
            $tiet = '';
            for($i = $e['tietbatdau']; $i <= $e['tietbatdau'] + $e['sotiet'] - 1;$i++){
                $tiet .= $i;
            }
            $phay = '';
            if($j < $numrow){
                $phay = ', ';
            }
            $res .= 'Thứ <b style="color:red">'.$e['thu'].'</b> tiết <b style="color: orange">'.$tiet.'</b> <span class="badge bg-primary">'.$e['phong'].'</span>'.$phay;
            $j++;
        }
    }
    return $res;
}
function getcookie($path){
    global $conn;
    $sql = "SELECT * FROM cookie WHERE path = '$path'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        while($entry = mysqli_fetch_row($kq)){
            return $entry[1];
        }
    }else{
        return "0";
    }
}
function getip(){
    return $_SERVER['REMOTE_ADDR'];
}
function getthongbao($id){
    global $conn;
    $sql = "SELECT * FROM thongbao WHERE ID = '$id'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        $entry = mysqli_fetch_assoc($kq);
        return $entry;
    }else{
        return 0;
    }
}
function timeago($ptime)
{
    $etime = time() - $ptime;
    if ($etime < 1)
    {
        return 'Vừa xong';
    }
    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'năm',
                       'month'  => 'tháng',
                       'day'    => 'ngày',
                       'hour'   => 'giờ',
                       'minute' => 'phút',
                       'second' => 'giây'
                );
    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' trước';
        }
    }
}
function getoption($entry){
    global $conn;
    $sql = "SELECT * FROM option WHERE name = '$entry' LIMIT 1";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        $e = mysqli_fetch_assoc($kq);
        return $e['value'];
    }else{
        return 0;
    }
}
function getTitle($url) {
    $page = file_get_contents($url);
    $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $page, $match) ? $match[1] : null;
    return $title;
}
//VARIABLE DEFINE
define('VERSION', getoption('version'));
date_default_timezone_set('Asia/Ho_Chi_Minh');
//session auto_start
session_start();
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>