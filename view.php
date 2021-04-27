<?
require './inc/head.php';
$view = 0;
if(isset($_GET['id'])){
    define('TB_ID', $_GET['id']);
    if(getthongbao(TB_ID) != 0){
        define('DATA_TB', getthongbao(TB_ID));
        $name = DATA_TB['name'];
        $nd = DATA_TB['noidung'];
        $author = DATA_TB['author'];
        $time = timeago(DATA_TB['time']);
        $time1 = DATA_TB['time'];
        $lastedit = DATA_TB['lastedit'];
        $title = $name.' - Hệ thống thông tin KTPM 04 K46';
        $view = 1;
    }
}
?>
<? if($view  == 1) : ?>
<div class="card mb-2">
    <div class="card-body">
        <h2><?=$name?></h2>
        <cite class="text-muted"><small>Bởi <b><?=$author?></b> (<?=gmdate('Y-m-d H:i:s', $time1).(($time1 != $lastedit) ? ', Cập nhật lần cuối '.timeago($lastedit) : '')?>)</small></cite>
        <p><?=$nd?></p>
    </div>
</div>
<div class="card mb-2">
<div class="card-header">Phản hồi cho bài viết</div>
<div class="card-body">
    <? if(login()) :?>
    <div class="row">
        <div class="col-2 text-center"><img src="<?=getsv(MSSV)['avatar']?>" style="max-width: 70%; border-radius: 50%; bodrder: 1px solid #000" /></div>
        <div class="col-10">
            <div id="content"></div>
            <form id="comment">
                <input type="hidden" name="post" value="<?=TB_ID?>" />
                <textarea class="form-control mb-2" name="noidung" id="comment_nd" required></textarea>
                <button type="submit" id="submit" name="gui" class="btn btn-success btn-sm">Phản hồi</button>
            </form>
            <script type="text/javascript">
                $(document).ready(function()
                { 
                    //khai báo biến submit form lấy đối tượng nút submit
                    var submit = $("#submit");
                    //khi nút submit được click
                    submit.click(function()
                    {
                        if($('#comment_nd').val() == ''){
                            alert("Vui lòng nhập nội dung!");
                            return false;
                        }
                        $('#content').html('<div class="alert alert-danger" role="alert" data-mdb-color="danger">Đang truy vấn CSDL <i class="fas fa-spinner fa-spin"></div>');
                        var data = $('form#comment').serialize();
                        $.ajax({
                            type : 'POST',
                            url : '/data.php?entry=comment',
                            data : data,
                            success : function(data)
                                        { 
                                        if(data == 0) 
                                        {
                                            $('#content').html('<div class="alert alert-danger" role="alert" data-mdb-color="danger">Không thể thêm bình luận!</div>');
                                        }else if(data == 1){
                                            $('#content').html('<div class="alert alert-danger" role="alert" data-mdb-color="danger">Đã thêm bình luận!');
                                            $('#comment').trigger('reset');
                                            $('#comment_load').load('/data.php?entry=showcomment&post=<?=TB_ID?>');
                                            setTimeout(() => {
                                                $('#content').slideUp();
                                            }, 3000);
                                        }
                                        }
                            });
                            return false;
                        });
                    });
            </script>
        </div>
    </div>
    <hr />
    
    <? endif ?>
    <!--comment-->
    <script>
    $(document).ready(function(){
        $('#comment_load').load('/data.php?entry=showcomment&post=<?=TB_ID?>');
    });
    </script>
    <div id="comment_load"><i class="fas fa-spinner fa-spin"></i> Đang tải bình luận...
  </div>
</div></div>
<? else: ?>

<?
echo '<div class="card mb-2"><ul class="list-group list-group-flush">';
$result = mysqli_query($conn, 'select count(ID) as total from thongbao');
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$total_page = ceil($total_records / $limit);
if ($current_page > $total_page){
    $current_page = $total_page;
}
else if ($current_page < 1){
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$result = mysqli_query($conn, "SELECT * FROM thongbao ORDER BY ID DESC LIMIT $start, $limit");
while ($e = mysqli_fetch_assoc($result)){
    echo '<li class="list-group-item"><a href="/view/'.$e['ID'].'">'.$e['name'].'</a> <small><i class="text-muted">'.timeago($e['time']).'</i></small><br/>
    <small class="text-muted">'.preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($e['noidung']), 0, 201)).'
</small></li>';
}
echo '</ul></div>';
echo ' <nav aria-label="Page navigation example">
<ul class="pagination">';
if ($current_page > 1 && $total_page > 1){
    echo '<li class="page-item"><a class="page-link" href="?page='.($current_page-1).'"><span aria-hidden="true">&laquo;</span>
    <span class="sr-only">Previous</span></a></li>';
}

// Lặp khoảng giữa
for ($i = 1; $i <= $total_page; $i++){
    // Nếu là trang hiện tại thì hiển thị thẻ span
    // ngược lại hiển thị thẻ a
    if ($i == $current_page){
        echo '<li class="page-item active"><a class="page-link">'.$i.' <span class="sr-only">(current)</span></a></li>';
    }
    else{
        echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
    }
}
// nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
if ($current_page < $total_page && $total_page > 1){
    echo '<li class="page-item"><a class="page-link" href="?page='.($current_page+1).'"><span aria-hidden="true">&raquo;</span>
    <span class="sr-only">Next</span></a></li>';
}
echo '</ul></nav>';
?>
<? endif ?>
<?
require './inc/foot.php';
?>