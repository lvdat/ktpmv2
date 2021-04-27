<?
$title = 'Chat';
include './inc/head.php';
?>
<div class="card mb-2"><div class="card-header bg-primary text-white">Chat</div>
<ul class="list-group list-group-flush">
    <? if(login()) :?>
    <div id="content"></div>
    <li class="list-group-item"><div class="row"><div class="col-2 text-center"><img src="<?=getsv(MSSV)['avatar']?>" width="50%" style="border-radius: 50%" /></div>
    <div class="col-10">
        <form id="chat_form">
        <div class="row">
        <div class="col-9">
        <input type="text" name="chat_nd" class="form-control" required />
        </div><div class="col-3">
        <button name="submit" type="submit" id="submit" class="btn btn-success">Gửi</button></div></div></form>
    </div>
    </div>
    </li>
    <script type="text/javascript">
            $(document).ready(function()
            { 
                //khai báo biến submit form lấy đối tượng nút submit
                var submit = $("#submit");
                //khi nút submit được click
                submit.click(function()
                {
                    if($('#chat_nd').val() == ''){
                        alert("Vui lòng nhập nội dung!");
                        return false;
                    }
                    $('#content').html('<div class="alert alert-danger" role="alert" data-mdb-color="danger">Đang truy vấn CSDL <i class="fas fa-spinner fa-spin"></div>');
                    var data = $('form#chat_form').serialize();
                    $.ajax({
                        type : 'POST',
                        url : '/data.php?entry=chat',
                        data : data,
                        success : function(data)
                                    { 
                                    if(data == 0) 
                                    {
                                        $('#content').html('<div class="alert alert-danger" role="alert" data-mdb-color="danger">Mỗi tin nhắn cần cách nhau 15s!</div>');
                                    }else if(data == 1){
                                        $('#content').html('<div class="alert alert-danger" role="alert" data-mdb-color="danger">Đã thêm dữ liệu!');
                                        $('#chat_form').trigger('reset');
                                        $('#chat_load').load('/data.php?entry=showchat');
                                        setTimeout(() => {
                                            $('#content').slideUp();
                                        }, 3000);
                                    }else if(data == 2){
                                        $('#content').html('<div class="alert alert-success" role="success">Đã thêm dữ liệu!');
                                    }
                                    }
                        });
                        return false;
                    });
                });
            </script>
    <? endif ?>
    </ul>
    <ul class="list-group list-group-flush">
    <div id="chat_load"><li class="list-group-item"><i class="fas fa-spinner fa-spin"></i> Đang tải nội dung chat...</li></div></ul>
    <script>
    $(document).ready(function(){
        $('#chat_load').load('/data.php?entry=showchat');
    });
    </script>
</div>

<?
include './inc/foot.php';
?>