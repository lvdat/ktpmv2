<?
if(isset($_GET['action'])){
    define('ACTION', $_GET['action']);
}else{
    header("Location: /admin");
}
$title = ACTION;
$editor = 1;
require './inc/head.php';
?>
<? if(ACTION == 'thongbao') :?>
    <?
        if(isset($_POST['gui'])){
        $name = $_POST['name'];
        $nd = $_POST['nd'];
        $author = MSSV;
        $time =  time();
        $add = "INSERT INTO thongbao (name, noidung, author, time, lastedit) VALUES ('$name', '$nd', '$author', '$time', '$time')";
        if($conn->query($add)){
            $tb = '<div class="alert alert-success" role="alert">Đã thêm dữ liệu!</div>';
        }else{
            $tb = '<div class="alert alert-danger" role="alert">Có sự cố xảy ra, hãy thử lại sau vài phút</div>';
        }
        }else{

        }
    ?>
    <div class="card">
        <div class="card-header bg-warning">Thêm thông báo mới</div>
        <div class="card-body">
        <?php if(isset($tb)){echo $tb;} ?>
        <form action="" method="post" id="identifier">
            <div class="form-group">
            <b>Tên thông báo</b>
            <input type="text" name="name" required class="form-control" />
            <b>Nội dung thông báo (cho phép dùng HTML)</b>
            <textarea name="nd" rows="10" placeholder="Nội dung thông báo" class="form-control mb-2"></textarea>
            </div>
            <button name="gui" class="btn btn-success" type="submit">Thêm thông báo</button>
        </form>
    </div></div>
<? else :?>
<? endif ?>


<?
require './inc/foot.php';
?>