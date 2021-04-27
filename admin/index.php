<?
$title = 'Trang quản trị';
require './inc/head.php';
?>
<div class="card mb-2">
    <div class="card-body">Chào mừng bạn đến với trang quản trị, phần lớn config của trang đều sẽ được chỉnh sửa ở đây!</div>
</div>
<div class="card mb-2">
    <div class="card-header bg-success text-white">
        <i class="fas fa-tools"></i> Bảng chức năng quản trị
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="/admin/create/thongbao" class="list-group-item list-group-item-action"><i class="fas fa-plus-circle"></i> Thêm thông báo</a>
            <a href="#" class="list-group-item list-group-item-action">A third link item</a>
            <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
        </div>
    </div>
</div>
<?
require './inc/foot.php';
?>