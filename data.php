<?php
require './inc/all.php';
if(isset($_GET['entry'])){
    $entry = $_GET['entry'];
}else{
    $entry = 'Wrong';
}
?>
<?php if($entry == 'gv') : ?>
<?php
if(isset($_POST['key']) && !empty($_POST['key'])){
    $key = addslashes($_POST['key']);
    $sql = "SELECT * FROM giangvien WHERE name LIKE '%$key%'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        echo '
        <div class="table-responsive">
        <table class="table table-bordered border-primary text-center mb-3" style="background-color: #fff">
  <thead class="thead-dark">
    <tr>
      <th scope="col">MSCB</th>
      <th scope="col">Họ và Tên</th>
      <th scope="col">Bộ môn</th>
      <th scope="col">Mail</th>
      <th scope="col">SDT</th>
      <th scope="col">Ngày sinh</th>
      <th scope="col">Trình độ</th>
      <th scope="col">LLKH</th>
    </tr>
  </thead>
  <tbody>';
            while($entry = mysqli_fetch_row($kq)){
                echo '
        <tr>
          <th scope="row">'.$entry[1].'</th>
          <td>'.$entry[2].'</td>
          <td>'.$entry[6].'</td>
          <td>'.$entry[3].'</td>
          <td>'.$entry[4].'</td>
          <td>'.$entry[7].'</td>
          <td>'.$entry[5].'</td>
          <td><a href="/cdn/files/llkh/LyLichKhoaHoc'.$entry[1].'.pdf" class="btn btn-primary">Tải LLKH</a></td>
        </tr>
      ';
            }
        echo '</tbody></table></div>';
        }else{
        echo '<div class="card"><div class="card-body"><div class="alert alert-danger" role="alert">
  Không có kết quả ứng với truy vấn của bạn !
</div></div></div>';
    }
}
?>
<?php elseif($entry == 'sv') :?>
<?php
if(isset($_POST['key'])){
    $key = addslashes($_POST['key']);
    $sql = "SELECT * FROM dssv WHERE name LIKE '%$key%'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0 && $key != " "){
        echo '
        <div class="table-responsive"><table class="table table-bordered border-primary text-center mb-3" style="background-color: #fff; border: 1px solid #000">
  <thead class="thead-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">MSSV</th>
      <th scope="col">Họ và Tên</th>
      <th scope="col">EXP</th>
      <th scope="col">Mail</th>
    </tr>
  </thead>
  <tbody>';
        while($entry = mysqli_fetch_row($kq)){
            if($entry[8] == 1){
                $check = '<i class="fas fa-check-circle" style="color: blue"></i>';
            }else{
                $check = "";
            }
            $name = $entry[1];
            $name = xoa_dau($name);
            $name = trim(preg_replace('/\s+/',' ', $name));
            $arrName = explode(' ', $name);
            echo '
    <tr>
      <th scope="row">'.$entry[0].'</th>
      <td>'.$entry[2].'</td>
      <td style="text-align:left"><img
        src="'.getsvbyID($entry[0])[5].'"
        height="27"
        alt=""
        loading="lazy" style="border-radius: 50%;"
      /> '.$entry[1].' '.$check.'</td>
      <td>'.$entry[9].'</td>
      <td>'.strtolower($arrName[count($arrName) - 1].''.$entry[2]).'@student.ctu.edu.vn</td>
    </tr>
  ';
        }
        echo '</tbody>
</table></div>';
    }else{
        echo '<div class="card"><div class="card-body"><div class="alert alert-danger" role="alert">
  Không có dữ liệu liên quan !
</div></div></div>';
    }
}
?>
<?php elseif($entry == 'rankexp') :?>
<?php
    echo '<div class="table-responsive"><table class="table table-bordered border-primary text-center mb-3" style="background-color: #fff; border: 1px solid #000">
  <thead class="table-dark">
    <tr>
      <th scope="col">MSSV</th>
      <th scope="col">Họ và Tên</th>
      <th scope="col">Mail</th>
      <th scope="col" class="text-primary">EXP</th>
    </tr>
  </thead>
  <tbody>';
    $sql = "SELECT * FROM dssv ORDER BY exp DESC";
    $kq = $conn->query($sql);
    $i = 1;
    while($entry = mysqli_fetch_row($kq)){
        if($entry[8] == 1){
                $check = ' <i class="fas fa-check-circle" style="color: blue"></i>';
            }else{
                $check = "";
            }
        $exp = '<span class="badge rounded-pill bg-primary">'.$entry[9].'</span>';
        if($i == 1){
            $class = ' style="background-color: red; color: #fff"';
        }elseif($i == 2){
            $class = ' style="background-color: orange; color: #fff"';
        }elseif($i == 3){
            $class = ' style="background-color: yellow"';
        }else{
            $class = '';
            $exp = $entry[9];
        }
        echo '<tr'.$class.'>
        <td>'.$entry[2].'</td>
        <td style="text-align:left"><img
        src="'.getsvbyID($entry[0])[5].'"
        height="27"
        alt=""
        loading="lazy" style="border-radius: 50%;"
      /> '.$entry[1].$check.'</td>
        <td>'.$entry[7].'</td>
        <td class="text-primary">'.$exp.'</td>
        </tr>';
        $i++;
    }
    echo '</tbody></table></div>';
?>
<?php elseif($entry == 'lichthi') :?>
<?php
    $tv = "SELECT * FROM lichthi";
    $kq = $conn->query($tv);
    if($kq->num_rows > 0){
        $i = 1;
        echo '
        <div class="table-responsive mb-3">
        <table class="table table-bordered border- text-center mb-2" style="background-color: #fff">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Thời gian</th>
      <th scope="col">Môn</th>
      <th scope="col">Chi tiết</th>
     </tr>
  </thead>
  <tbody>';
        while($entry = mysqli_fetch_row($kq)){
            echo '
            <tr>
          <td>'.$entry[3].'</td>
          <td>'.$entry[1].'</td>
          <td><a href="/thi.php?id='.$entry[0].'" class="btn btn-primary">Chi tiết </a></td>
        </tr>';
        }   
    }else{
        echo 'Trống';
    }
    echo '</tbody></table></div>';
?>
<?php elseif($entry == 'btl') :?>
<?php
    $tv = "SELECT * FROM btl ORDER BY ID";
    $kq = $conn->query($tv);
    if($kq->num_rows > 0){
        $i = 1;
        echo '
        <div class="table-responsive mb-3">
        <table class="table table-bordered border- text-center mb-2" style="background-color: #fff">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Nhóm</th>
      <th scope="col">Chủ đề</th>
      <th scope="col">Tải về</th>
     </tr>
  </thead>
  <tbody>';
        while($entry = mysqli_fetch_row($kq)){
            echo '
            <tr>
          <td>Nhóm '.$entry[1].'</td>
          <td>'.$entry[4].'</td>
          <td>
          <a href="/cdn/files/thuyettrinh/'.$entry[1].'/nhom'.$entry[1].'.docx" class="text-primary"><i class="fas fa-file-word"></i>docx</a>';
          if($entry[3]==1){echo ', <a href="/cdn/files/thuyettrinh/'.$entry[1].'/nhom'.$entry[1].'.pptx" style="color: orange"><i class="fas fa-file-powerpoint"></i>PPTX</a>';
              }
          echo '</td>
        </tr>';
        }   
    }else{
        echo 'Trống';
    }
    echo '</tbody></table></div>';
?>
<?php elseif($entry == 'login') :?>
<?php
if(isset($_POST['mssv']) && isset($_POST['password'])){
    $mssv = strtoupper(addslashes($_POST['mssv']));
    $pass = md5(addslashes($_POST['password']));
    $sql = "SELECT mssv, password FROM dssv WHERE mssv = '$mssv' AND password = '$pass'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        echo 1;
        //thong tin dung
        $_SESSION['logged'] = $mssv;
        $path = str_random(8).'_'.str_random(4).'_'.str_random(5).'_'.str_random(100);
        setrawcookie('path', $path, time() + 864000);
        $sql = "INSERT INTO cookie (path, mssv) VALUES ('$path', '$mssv')";
        $conn->query($sql);
    }else{
        echo 0;
    }
}else{
    echo -1;
    //chua du thong tin
}
?>
<?php elseif($entry == 'addhp') : ?>
<?php
if(isset($_POST['mahp'])){
        $mahp = $_POST['mahp'];
        $name = $_POST['name'];
        $tinchi = $_POST['tinchi'];
        $lithuyet = $_POST['lithuyet'];
        $thuchanh = $_POST['thuchanh'];
        $tienquyet = $_POST['tienquyet'];
        $songhanh = $_POST['songhanh'];
        $sql = "SELECT * FROM hocphan WHERE mahp = '$mahp'";
        $kq = $conn->query($sql);
        if($kq->num_rows > 0){
            echo 1;
        }else{
            $sql = "INSERT INTO hocphan (mahp, name, tinchi, lithuyet, thuchanh, tienquyet, songhanh) VALUES ('$mahp', '$name', '$tinchi', '$lithuyet', '$thuchanh', '$tienquyet', '$songhanh')";
            $kq = $conn->query($sql);
            if($kq){
                echo 3;
            }else{
                echo 2;
            }
        }
    }else{
        echo 0;
    }
?>
<?php elseif($entry == 'hp') : ?>
<?php
$sql = "SELECT * FROM hocphan";
$truyvan = $conn->query($sql);
if($truyvan->num_rows > 0){
    echo '<div class="table-responsive">
    <table class="table table-bordered border-primary text-center mb-3" style="background-color: #fff">
<thead style="background-color: #000;color: #fff">
<tr>
  <th scope="col">Mã HP</th>
  <th scope="col">Tên học phần</th>
  <th scope="col">Số TC</th>
  <th scope="col">Tiết LT</th>
  <th scope="col">Tiết TH</th>
  <th scope="col">HP tiên quyết</th>
  <th scope="col">HP song hành</th>
  <th scope="col">Ghi chú</th>
</tr>
</thead>
<tbody>';
    while($entry = mysqli_fetch_row($truyvan)){
        echo '<tr>';
        for($i = 1; $i <= 8; $i++){
            echo '<td>'.$entry[$i].'</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}else{
    echo "Lỗi lấy dữ liệu";
}
?>
<?php elseif($entry == 'lophp') : ?>
<?php
if(isset($_POST['mahp'])){
    $mahp = $_POST['mahp'];
    $malop = $_POST['malop'];
    $siso = $_POST['siso'];
    $sql = "SELECT * FROM lophp WHERE malop = '$malop'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        echo 1;
    }else{
        $sql = "INSERT INTO lophp (mahp, malop, siso) VALUES ('$mahp', '$malop', '$siso')";
        $kq = $conn->query($sql);
        if($kq){
            echo 3;
        }else{
            echo 2;
        }
    }
}else{
    echo 0;
}
?>
<?php elseif($entry == 'optionlophp') :?>
<?php
if(isset($_POST['mahp'])){
    $mahp = $_POST['mahp'];
    $sql = "SELECT * FROM lophp WHERE mahp = '$mahp'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        while($entry = mysqli_fetch_assoc($kq)){
            echo '<option value="'.$entry['malop'].'">'.$entry['malop'].'- SS: '.$entry['siso'].'</option>';
        }
    }else{
        echo '<option>Không có dữ liệu cho học phần này<option>';
    }
}else{
    echo 'NULL';
}
?>
<?php elseif($entry == 'lichhp') :?>
    <?php
if(isset($_POST['mahp'])){
    $thu = $_POST['thu'];
    $malop = $_POST['malop'];
    $tietbatdau = $_POST['tietbatdau'];
    $sotiet = $_POST['sotiet'];
    $phong = $_POST['phong'];
    $sql = "SELECT * FROM lichlophp WHERE malop = '$malop' AND thu = '$thu' AND tietbatdau = '$tietbatdau' AND sotiet = '$sotiet'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        echo 1;
    }else{
        $sql = "INSERT INTO lichlophp (malop, thu, tietbatdau, sotiet, phong) VALUES ('$malop', '$thu', '$tietbatdau', '$sotiet', '$phong')";
        $kq = $conn->query($sql);
        if($kq){
            echo 3;
        }else{
            echo 2;
        }
    }
}else{
    echo 0;
}
?>
<?php elseif($entry == 'showlophp') :?>
<?php
if(isset($_POST['mahp'])){
    $mahp = $_POST['mahp'];
    $sql = "SELECT * FROM lophp WHERE mahp = '$mahp'";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        $i = 1;
        echo '
        Các lớp mở cho học phần: <b>'.gethocphan($mahp)['name'].'</b>.<br />Số tín chỉ: <b>'.gethocphan($mahp)['tinchi'].'</b>
        <div class="table-responsive"><table class="table table-bordered border-primary text-center mb-3" style="background-color: #fff; border: 1px solid #000">
        <thead style="background-color: #000; color: #fff">
          <tr>
            <th scope="col">TT</th>
            <th scope="col">Mã lớp</th>
            <th scope="col">Sỉ số</th>
            <th scope="col">Thời gian giảng dạy</th>
          </tr>
        </thead>
        <tbody>';
        while($e = mysqli_fetch_assoc($kq)){
        $malop = $e['malop'];
            echo '<tr>
                <td>'.$i.'</td>
                <td><b>'.$malop.'</b></td>
                <td>'.$e['siso'].'</td>
                <td>'.gettimehp($malop).'
            </tr>';
            $i++;
        }
        echo '</tbody></table></div>';
    }else{
        echo 'Không có dữ liệu, nếu bạn có định đăng ký học phần này xin liên hệ với mình để bổ sung! datb2012191@student.ctu.edu.vn';
    }
}
?>
<?php elseif($entry == 'testlist') :?>
<div class="table-responsive">
        <table class="table table-bordered border-primary text-center mb-3" style="background-color: #fff">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="width:40%">Name</th>
      <th scope="col" style="width:30%">Ngày diễn ra</th>
      <th scope="col" style="width:15%">Thời gian</th>
      <th scope="col" style="width:15%">Số câu hỏi</th>
    </tr>
  </thead>
  <tbody>
  <?php
  	$sql = "SELECT * FROM test";
  	$kq = $conn->query($sql);
  	if($kq->num_rows > 0){
  		while($e = mysqli_fetch_assoc($kq)){
              $id = $e['ID'];
            $sql2 = "SELECT test FROM cauhoi WHERE test = '$id'";
            $socau = $conn->query($sql2)->num_rows;
              echo '<tr>
              <td><a href="/test/'.$e['ID'].'">'.$e['name'].'</a></td>
              <td>'.date("d-m-Y H:i:s", $e['ngay']).'</td>
              <td>'.$e['time'].' phút </td>
              <td>'.$socau.'</td>
              </tr>';
  		}
  	}else{
  	echo 'Hiện tại không có bài TEST nào';
  	}
  ?>
  </tbody></table></div>
<?php elseif($entry == 'bxhtest') : ?>
<?php
if(isset($_GET['test'])){
    $test = $_GET['test'];
    $sql = "SELECT * FROM total WHERE test = '$test' ORDER BY score";
    $kq = $conn->query($sql);
    if($kq->num_rows > 0){
        $sql2 = "SELECT * FROM cauhoi WHERE test = '$test' ORDER BY so";
        $kq2 = $conn->query($sql2);
        echo '<div class="table-responsive"><table class="table table-bordered border-primary text-center mb-3" style="background-color: #fff; border: 1px solid #000">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Họ và Tên</th>';
            $socau = $kq2->num_rows;
            if($socau > 0){
                while($f = mysqli_fetch_assoc($kq2)){
                    echo '<th scope="col">C'.$f['so'].'</th>';
                }
            }
            //chỗ này lặp số câu <th></th>
        echo '<th scope="col">Tổng điểm</th>
        </tr>
      </thead>
      <tbody>';
      	$i = 1;
        // xuat du lieu tung dong
        while($e = mysqli_fetch_assoc($kq)){
            echo '<td>'.$i.'</td>
                    <td>'.getsv($e['mssv'])[1].'</td>';
                $mssv = $e['mssv'];
            for($j = 1; $j <= $socau; $j++){
                echo '<td>';
                $question = getcauhoi($test, $j);
                $sql3 = "SELECT * FROM pass WHERE mssv = '$mssv' AND question = '$question'";
                $kq3 = $conn->query($sql3);
                if($kq3->num_rows > 0){
                    while($g = mysqli_fetch_assoc($kq3)){
                        echo $g['score'];
                    }
                }else{
                    echo '-';
                }
                echo '</td>';
            }
            echo '<td>'.$e['score'].'</td>';
            $i++;
        }
        echo '</tbody>
        </table></div>';
    }else{
        echo '<b>Chưa có dữ liệu</b>';
    }
}
?>
<? elseif($entry == 'comment'): ?>
<? if(isset($_POST['noidung'])){
    if(login()){
        $author = $_SESSION['logged'];
        $nd = $_POST['noidung'];
        $time = time();
        $post = $_POST['post'];
        $sql = "INSERT INTO binhluan (noidung, author, post, time) VALUES ('$nd', '$author', '$post', '$time')";
        $kq = $conn->query($sql);
        if($kq){
            echo 1;
        }else{
            echo 0;
        }
    }else{
        echo 0;
    }
}else{
    echo 0;
}
?>
<? elseif($entry == 'showcomment'): ?>
<? if(isset($_GET['post'])){
    $tb_id = $_GET['post'];
    if(getthongbao($tb_id) != 0){
        $sql = "SELECT * FROM binhluan WHERE post = '$tb_id' ORDER BY ID DESC";
        $kq = $conn->query($sql);
        if($kq->num_rows > 0){
            while($e = mysqli_fetch_assoc($kq)){
                echo '<div class="card mb-2">
                <div class="card-body">
                <div class="row">
                    <div class="col-2 text-center"><img src="'.getsv($e['author'])['avatar'].'" width="50%" style="border-radius: 50%"></div>
                    <div class="col-10 text-left"><b>'.getsv($e['author'])['name'].'</b> <span class="badge bg-secondary">'.$e['author'].'</span><br />
                    <small><i class="text-muted">'.timeago($e['time']).'</i></small><br/>
                    <p>'.strip_tags($e['noidung'], '<b><a><p><br><i><u><font>').'</p>
                    </div>
                </div></div></div>';
            }
        }else{
            echo '<div class="card-body text-center">Chưa có bình luận</div>';
        }
    }else{
        echo 'Lỗi dữ liệu';
    }
}  
?>
<? elseif($entry == 'chat'): ?>
<? if(login()){
    if(isset($_POST['chat_nd'])){
        $author = $_SESSION['logged'];
        $nd = $_POST['chat_nd'];
        $time = time() - 15;
        $sql = "SELECT * FROM chat WHERE author = '$author' AND time >= $time";
        if($conn->query($sql)->num_rows > 0){
            echo 0;
        }else{
            $time += 15;
            $sql = "INSERT INTO chat (noidung, author, time) VALUES ('$nd', '$author', '$time')";
            if($conn->query($sql)){
                echo 1;
            }else{
                echo 2;
            }
        }
    }
}
?>
<? elseif($entry == 'showchat') : ?>
<? 
$sql = "SELECT * FROM chat ORDER BY ID DESC";
$kq = $conn->query($sql);
if($kq->num_rows > 0){
    while($e = mysqli_fetch_assoc($kq)){
        echo '<li class="list-group-item text-left"><b>'.getsv($e['author'])['name'].'</b> <span class="badge bg-secondary">'.$e['author'].'</span>: '.strip_tags($e['noidung'], '<b><a><p><br><i><u><font>').'</li>';
    }
}else{
    echo '<li class="list-group-item">Không có tin chat</li>';
}
?>
<?php else :?>
<i>Wrong data.</i>
<?php endif ?>