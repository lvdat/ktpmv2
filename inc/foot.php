                </div>
                <div class="col-md-3">
                    <div class="sticky">
                        <div class="card mb-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center">
                                    <? if(!login()): ?>
                                        <p>Đăng nhập để tối ưu hóa trải nghiệm và cá nhân hóa nội dung</p>
                                        <a onclick="dangnhap()" title="Đăng nhập" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP HỆ THỐNG</a>
                                    <? else: ?>
                                        <img style="max-width: 43%;border: 3px solid #ab1170;border-radius: 50%" src="<?=getsv(MSSV)['avatar'];?>">
                                    <? endif ?>
                                </li>
                                <? if(login()) :?>
                                <li class="list-group-item text-center"><?if(getsv(MSSV)['level'] > 0){echo '<span class="badge bg-danger"><i class="fas fa-user-shield"></i> ADMIN</span> ';}?><span class="badge bg-secondary"><?=MSSV?></span> <b><?=getsv(MSSV)['name']?></b></li>
                                <? endif ?>
                            </ul>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Thông báo mới</div>
                            <ul class="list-group list-group-flush">
                                <?
                                $sql = "SELECT * FROM thongbao ORDER BY ID DESC LIMIT 5";
                                $kq = $conn->query($sql);
                                if($kq->num_rows == 0){
                                    echo 'Không có thông báo';
                                }else{
                                    while($e = mysqli_fetch_assoc($kq)){
                                        echo '<li class="list-group-item"><a href="/view/'.$e['ID'].'">'.$e['name'].'</a> <small><i class="text-muted">'.timeago($e['time']).'</i></small></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Ai đang trực tuyến?</div>
                            <div class="card-body">
                            <?
                                $sql = "SELECT name, lastlogin, level FROM dssv";
                                $kq = $conn->query($sql);
                                $i = 0;
                                while($e = mysqli_fetch_assoc($kq)){
                                    $ago = time() - $e['lastlogin'];
                                    $name = $e['name'];
                                    if($i > 0 && $ago < 3600){
                                        echo ', ';
                                    }
                                    if($e['level'] > 0){
                                        $name = '<i class="fas fa-wrench" style="color:red"></i> '.$e['name'];
                                    }
                                    if($ago <= 60){
                                        echo '<b>'.$name.'</b> <i class="fas fa-circle" style="color:green"></i>';
                                    }elseif($ago > 60 && $ago < 3600){
                                        echo '<b>'.$name.'</b><span class="badge rounded-pill bg-light text-dark"><i>'.round($ago/60, 0).' phút trước</i></span>';
                                    }else{
                                        
                                    }
                                    $i++;
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="bg-light text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            KTPM <sup>K46</sup> SYSTEM © 2020-2021 BY 
            <a class="text-dark" target="_blank" href="https://www.facebook.com/vilogger.dev/">DATLEVAN</a>
        </div>
        <!-- Copyright -->
        </footer>
        <!-- Footer -->
        </div>
    </body>
</html>
<? echo '<!-- Time server: '.time().'
Author: Le Van Dat-->'; ?>