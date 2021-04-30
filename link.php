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
                <input type="hidden" name="hash" value="<?=$hash?>">
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
                    <div class="card-header bg-success text-white"><i class="fas fa-link"></i> URL Detect</div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered border-primary">
                            <tbody>
                                <tr>
                                    <td width="35%"><b>Tên liên kết</b></td>
                                    <td width="65%">'.$entry['name'].'</td>
                                </tr>
                                <tr>
                                    <td width="35%"><b>Liên kết gốc</b></td>
                                    <td width="65%"><textarea class="form-control" disabled>'.$entry['real_url'].'</textarea></td>
                                </tr>
                                <tr>
                                    <td width="35%"><b>Người tạo</b></td>
                                    <td width="65%">'.getsv($entry['author'])['name'].'</td>
                                </tr>
                                <tr>
                                    <td width="35%"><b>Đã tạo vào</b></td>
                                    <td width="65%">'.timeago($entry['time']).'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-primary" role="alert">
                        Click vào nút bên dưới để đi đến liên kết ngay mà không cần chờ!
                    </div>
                    <script>
                        var timeleft = 10;
                        var myvar;
                        var downloadTimer = setInterval(function(){
                        if(timeleft <= 0){
                            clearInterval(downloadTimer);
                            document.getElementById("countdown").innerHTML = "Đang xử lý";
                        } else {
                            document.getElementById("countdown").innerHTML = "Tự động chuyển đến liên kết sau " + timeleft + " giây";
                        }
                        timeleft -= 1;
                        }, 1000);
                        function go(){
                            window.open("'.$entry['real_url'].'", "_blank");
                            window.history.back();
                            clearTimeout(myvar);
                        }
                        myvar = setTimeout(function(){
                            go();
                        }, 11000);
                    </script>
                        <div class="text-center" id="countdown"></div>
                        <button class="btn btn-primary center" onclick="go()">Đi đến liên kết</button>            
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