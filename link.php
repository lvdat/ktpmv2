<?
include './inc/head.php';
if(!login()){
    header("Location: /");
}
$action = (isset($_GET['action'])) ? $_GET['action'] : 'create';
?>
<? if($action == 'create') :?>
    <? if(isset($_POST['gui'])){
        $real_url = $_POST['url'];
        $hash = $_POST['hash'];
        $author = MSSV;
        $time = time();
        $name = getTitle($real_url);
        $sql = "INSERT INTO link (name, hash, real_url, author, time) VALUES ('$name', '$hash', '$real_url', '$author', '$time')";
        echo ($conn->query($sql)) ? 'Đã thêm dữ liệu' : 'Có lỗi xảy ra';
    }
    ?>
    <div class="card"><div class="card-header bg-primary text-white">Rút gọn liên kết</div>
        <div class="card-body">
            <form action="" method="POST">
                <label>Nhập URL cần rút gọn</label>
                <input type="text" name="url" required>
                <label>Hash link: (link có dạng ktpmk46.tech/go/hash)</label>
                <? $hash = str_random(8); ?>
                <input type="text" name="hash" value="<?=$hash?>" required>
                <button type="submit" name="gui" class="btn btn-success">Gửi dữ liệu</button>
            </form>
        </div>
    </div>
<? elseif($action == 'view'): ?>
    <?
        if(isset($_GET['hash'])){
            $hash = $_GET['hash'];
            $sql = "SELECT * FROM link WHERE hash = '$hash' LIMIT 1";
            $kq = mysqli_query($conn, $sql);
            if($kq->num_rows > 0){
                while($entry = mysqli_fetch_assoc($kq)){
                    echo '
                    <div class="card mb-2">
                    <div class="card-header bg-success text-white">Đi tới liên kết gốc</div>
                    <div class="card-body">
                    <p class="card-text">'.$entry['name'].'</p>
                    <p class="card-text">Liên kết gốc: '.$entry['real_url'].'</p>
                    <script>
                        var timeleft = 4;
                        var downloadTimer = setInterval(function(){
                        if(timeleft <= 0){
                            clearInterval(downloadTimer);
                            document.getElementById("countdown").innerHTML = "Đang chuyển hướng";
                        } else {
                            document.getElementById("countdown").innerHTML = "Tự động chuyển sau " + timeleft + " giây";
                        }
                        timeleft -= 1;
                        }, 1000);
                        setTimeout(function(){
                            window.open("'.$entry['real_url'].'", "_blank");
                        }, 5000);
                    </script>
                        <div class="text-center" id="countdown"></div>
                                        
                    </div>
                    </div>
                    ';
                }
            }else{
                echo 'Liên kết này không tồn tại';
            }
        }else{
            header("Location: /");
        }
    ?>
<? endif ?>
<? include './inc/foot.php'; ?>