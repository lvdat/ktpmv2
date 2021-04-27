<?
$title = 'Tài khoản';
include './inc/head.php';
$mssv = MSSV;
if(login()){
    if(isset($_GET['action'])){
        $action = $_GET['action'];
        if($action == 'view'){
            if(isset($_GET['mssv'])){
                $mssv = $_GET['mssv'];
            }
        }
    }else{
        header("Location: /");
    }
}else{
    header("Location: /dangnhap");
}
?>
<? if($action == 'view') :?>
<? elseif($action == 'edit'): 
    $navbar = '<div class="card mb-2"><div class="card-header bg-primary text-white">Cài đặt tài khoản</div><ul class="list-group list-group-flush"><a class="list-group-item list-group-item-action" href="/profile/edit/general"><i class="fas fa-user-cog"></i> Thông tin chung</a><a class="list-group-item list-group-item-action" href="/profile/edit/avatar"><i class="fas fa-image"></i> Ảnh đại diện</a><a class="list-group-item list-group-item-action" href="/profile/edit/security"><i class="fas fa-shield-alt"></i> Mật khẩu</a></ul></div>';
    ?>
    <div class="card mb-2"><div class="card-body">Chào mừng bạn đến với trang quản trị người dùng!</div></div>
    <? if(!isset($_GET['edit_action'])) : ?>
        <?=$navbar?>
    <? else: ?>
    <script>
        $('#head_addon').html('<?=$navbar?>');
    </script>
    <? $action_edit = $_GET['edit_action']; 
    if($action_edit == 'general') :?>
    <div class="card mb-2"><div class="card-header bg-success text-white"><i class="fas fa-info-circle"></i> Thông tin chung</div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
        <div class="alert alert-primary" role="alert">
        Các mục không thể chỉnh sửa do là thông tin cố định. Nếu có sai sót vui lòng liên hệ mình để chỉnh sửa nhé, các thông tin này sẽ được sử dụng trong các công việc liên quan đến lớp, Đoàn,... và sẽ được bảo mật tất cả
        </div></li>
        <li class="list-group-item">
            <div class="form-group row">
            <div class="col-md-3 text-center">Tên SV: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['name']?>"></div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group row">
            <div class="col-md-3 text-center">MSSV: </div><div class="col-md-9"><input class="form-control" disabled value="<?=MSSV?>"></div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group row">
            <div class="col-md-3 text-center">Email: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['mail']?>"></div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="form-group row">
            <div class="col-md-3 text-center">SDT cá nhân: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['sdt']?>"></div>
            </div>
        </li>
    </ul>
    </div>
    <div class="card mb-2">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="form-group row">
                <div class="col-md-3 text-center">Chức vụ: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['chucvu']?>"></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group row">
                <div class="col-md-3 text-center">Ngày vào Đoàn: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['ngayvaodoan']?>"></div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card mb-2">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="form-group row">
                <div class="col-md-3 text-center">(Trọ/Nhà/KTX): </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['noiohientai']?>"></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group row">
                <div class="col-md-3 text-center">Quê quán: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['quequan']?>"></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group row">
                <div class="col-md-3 text-center">SDT gia đình: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['sdtgiadinh']?>"></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="form-group row">
                <div class="col-md-3 text-center">SDT chủ trọ/bạn cùng phòng: </div><div class="col-md-9"><input class="form-control" disabled value="<?=getsv(MSSV)['sdtbancungphong']?>"></div>
                </div>
            </li>
        </ul>
    </div>
    <? elseif($action_edit == 'avatar') :?>
    <?
        // Nếu người dùng click Upload
        if (isset($_POST['uploadclick']))
        {
            // Nếu người dùng có chọn file để upload
            if (isset($_FILES['avatar']))
            {
                // Nếu file upload không bị lỗi,
                // Tức là thuộc tính error > 0
                if ($_FILES['avatar']['error'] > 0)
                {
                    $nodata = 1;
                    $error = "File quá lớn, có nhiễm virus hoặc không hợp lệ";
                }
                else{
                    $target_dir = "./cdn/avatars/";
                    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
                        if($check !== false) {
                            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg"
    || $imageFileType == "gif" ) {
                                // Upload file
                                $file = $mssv.'_avatars_'.time().'_'.md5(time()).'.'.$imageFileType;
                                move_uploaded_file($_FILES['avatar']['tmp_name'], $target_dir.$file);
                                $slug = "/cdn/avatars/".$file;
                                $id = getsv(MSSV)['ID'];
                                $sql = "UPDATE dssv SET avatar = '$slug' WHERE ID = $id";
                                if($conn->query($sql)){
                                    $nodata = 2;
                                }else{
                                    $nodata = 1;
                                    $error = "Máy chủ quá tải, xin vui lòng thử  lại sau !";
                                }
                            }else{
                                $nodata = 1;
                                $error = "Vui lòng tải file có định dạng: <b>jpg, jpeg, png, gif</b> !";
                            }
                        } else {
                            $nodata = 1;
                            $error = "File bạn upload không phải là hình ảnh !";
                        }
                }
            }
            else{
                echo 'Bạn chưa chọn file upload';
            }
        }
    ?>
        <div class="card"><div class="card-header bg-warning text-white">Thay đổi avatar</div>
            <div class="card-body">
            <? if(isset($nodata)){
                if($nodata == 1){
                    echo '<div class="alert alert-danger" role="alert" data-mdb-color="danger">
                    <i class="fas fa-exclamation-triangle"></i> '.$error.'
                </div>';
                }else{
                    echo '<div class="alert alert-success" role="alert" data-mdb-color="success">
                    Đã cập nhật ảnh đại diện của bạn!
                </div>';
                }
            }
            ?>
                <p class="card-text">Tải lên avatar của bạn tại đây. Định dạng cho phép: <b>jpg, jpeg, png, gif</b></p>
                <center class="mb-2"><img
                    src="<?=getsv(MSSV)['avatar']?>" width="50%" style="max-width:120px;border-radius: 50%;"
                loading="lazy" /></center>
                <form action="" method="post" enctype="multipart/form-data" id="up-avatar">
                    <input type="file" name="avatar" class="form-control" id="filee" required><br>
                    <button type="submit" name="uploadclick" class="btn btn-primary" id="submitt" onclick="chuyen()">Tải lên <i class="fas fa-cloud-upload-alt"></i></button>
                </form>
                    <div id="loader-icon" style="display:none;">Đang tải lên...</div>
                <script>
                    function chuyen() {
                        if($('#filee').val()){
                        document.getElementById("submitt").innerHTML = "Đang tải lên <i class='fas fa-spinner fa-spin'></i>";
                        }else{
                            alert('Vui lòng chọn file');
                        }
                    };
                </script>
            </div>
        </div>
    <? elseif($action_edit == 'security') :?>
    <?
    if(login()){
        $mssv = $_SESSION['logged'];
        if(isset($_POST['pass']) && isset($_POST['pass2'])){
          $pass = md5(addslashes($_POST['pass']));
          if($pass == getsv(MSSV)['password']){
            $pass2 = md5(addslashes($_POST['pass2']));
            $id = getsv(MSSV)['ID'];
            if(getsv(MSSV)['active'] == 0){
              $sql = "UPDATE dssv SET active = 1 WHERE ID = $id";
              if($conn->query($sql)){
                  $success = 1;
              }
            }
              $sql = "UPDATE dssv SET password = '$pass2' WHERE ID = $id";
            if($conn->query($sql)){
              $success = 1;
            }else{
              $error = "Hệ thống đang quá tải, vui lòng thử lại sau ít phút";
            }
          }else{
            $error = "Mật khẩu hiện tại không đúng";
          }
        }
      }else{
        header('Location: /');
        exit;
      }
      ?>
      <div class="card mb-2"><div class="card-header bg-dark text-white">Mật khẩu</div>
          <div class="card-body">
            <?php if(isset($success) && $success == 1) : ?>
                <div class="alert alert-success">
                    <i class="fas fa-check"></i> Đã thay đổi mật khẩu! Bạn sẽ cần phải đăng nhập lại sau khi đổi mật khẩu!
                    <script>
                    setTimeout(() => {
                        window.location = "/logout?redirect=/dangnhap";
                    }, 2000);
                    </script>
                </div>
            <?php elseif (isset($error)) : ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> <?=$error?>
                </div>
            <?php endif ?>
            <div class="alert alert-danger" role="alert" data-mdb-color="danger" id="hint" style="display: none">
                <i class="fas fa-exclamation-triangle"></i> Mật khẩu phải có độ dài ít nhất 6 ký tự
            </div>
              <form action="" method="POST" id="change">
                <p class="card-text">
                  Nhập mật khẩu hiện tại:
                </p>
                <div class="input-group mb-3">
                  <input id="passs" type="password" class="form-control" name="pass" required maxlength="36" placeholder="Mật khẩu" />
                </div>
                <p class="card-text">
                  Nhập mật khẩu mới:
                </p>
                <div class="input-group mb-3">
                  <input id="passss" type="text" class="form-control" name="pass2" required maxlength="36" placeholder="Mật khẩu mới" /><br>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block" id="submitt">Đổi mật khẩu</button>
              </form>
      <script>
      $("#change").submit(function(e){
        if($('#passss').val().length < 6 || $('#passs').val().length < 6){
          e.preventDefault();
          $('#hint').show();
        }else{
          document.getElementById("submitt").innerHTML = "Đang xử lý <i class='fas fa-spinner fa-spin'></i>";
        }
        });
      </script>
</div>

</div>
    <? endif ?>

    <? endif ?>
<? endif ?>
<?
include './inc/foot.php';
?>