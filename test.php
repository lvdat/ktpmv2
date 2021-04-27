<div class="card mb-2">
<div class="card-body">
<div class="row">
    <div class="col-2 text-center"><img src="'.getsv($e['author'])['avatar'].'" width="50%" style="border-radius: 50%"></div>
    <div class="col-10 text-left"><b>'.getsv($e['author'])['name'].'</b> <span class="badge bg-secondary">'.$e['author'].'</span><br />
    <small><i class="text-muted">'.timeago($e['time']).'</i></small><br/>
    <p>'.$e['noidung'].'</p>
    </div>
</div></div></div>