<? session_start();
# gọi thằng DB vào đây 
include './inc/all.php';
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
  header("Location: /");
}
if(isset($_GET['unset']) && $_GET['unset']=='true' && isset($_SESSION['mssv'])){
  unset($_SESSION['mssv']);
  header("Location: /dangnhap");
}
# xử lý chỗ lày
if(isset($_SESSION['mssv'])){
  #Nếu đã tồn tại SESSION mssv, ta sẽ hiển thị form nhập mật khẩu
  $ok = 1;
  $mssv = $_SESSION['mssv'];
}else{
  # Nếu chưa tồn tại SESSION
    if(isset($_POST['mssv'])){
      # nếu đã submit form 1, ta kiểm tra user này có trong csdl hay không
      $mssv = $_POST['mssv'];
      $sql = "SELECT name,mssv FROM dssv WHERE mssv = '$mssv'";
      if($conn->query($sql)->num_rows > 0){
        #Nếu tìm thấy MSSV này trong CSDL thì gán SESSION tạm thời
        $_SESSION['mssv'] = $mssv;
        $ok = 1;
      }else{
        # Nếu không có MSSV này
        $ok = 0;
      }
    }else{
      # nếu chưa submit form 1 thì hiện form lên
      $ok = -1;
    }
}
?>
<html lang="en">
  <head>
    <title>Đăng nhập tài khoản - Hệ thống thông tin KTPM 04 K46</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/asset/css/login.css?v=<?=time()?>" />
    <link href="/fontawesome/css/all.css" rel="stylesheet" />
    <script type="text/javascript" src="/asset/js/jquery.min.js"></script>
  </head>
<body>
  <div class="nav">
  <b style="color: red">ktpm</b><b style="color: blue">system</b> <sup><small style="color:#393d40">&#x2764; KTPM04</small></sup> <span id="logout"></span>
  </div>
  <div class="wrapper">
	<div class="container">
    <? if($ok == 0 || $ok == -1) : ?>
    <? if($ok == 0): ?>
      <div id="danger" class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
          <strong class="font__weight-semibold">MSSV không có trong CSDL</strong>
      </div>
      <script>
        setTimeout(() => {
          $('#danger').fadeOut(1000);
        }, 2000);
      </script>
    <? endif ?>
		<h2>Xin chào, hãy nhập MSSV của bạn:</h2>
		<form class="form" action="" method="POST">
      <input id="mssv" type="text" name="mssv" placeholder="MSSV" required />
      <button id="dangnhap">Đăng nhập</button>
		</form>
	<script>
    $(document).ready(function(){
      var submit = $('#dangnhap');
      submit.click(function(){
        if($('#mssv').val() != ''){
          submit.html('Đang truy vấn dữ liệu');
        }
      });
    });
  </script>
    <? elseif($ok == 1) :?>
    <div id="content"></div>
    <h2>Xin chào, <?=getsv($mssv)['name']?> </h2> 
    <script>
      $("#logout").html('| <small><a href="?unset=true">Đăng nhập tài khoản khác</a></small>');
    </script>
    <img src="<?=getsv($mssv)['avatar']?>" width="35%" height="auto" style="max-width:50%;border-radius:50%;border: 4px solid #ab1170;" alt="avatar" />
      <form class="form" action="" method="POST" id="pass">
        <h3>Hãy nhập mật khẩu để tiếp tục:</h3>
        <input type="password" name="password" id="password" placeholder="Mật khẩu" required />
        <button name="submit" id="submit">Đăng nhập</button>
      </form>
    <script type="text/javascript" src="/asset/js/login.min.js"></script>
    <? endif ?>
    </div>
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<div class="foot">
<img src="/co.png"> <?=getip()?> &nbsp;  <a target="_blank" href="https://codetrain.co"><i class="fab fa-free-code-camp"></i>CodeTrain</a>
</div>
  </body>
</html>