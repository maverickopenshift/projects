@extends('layouts.app')
@section('content')
@php
$id=0;
$parent_id=0;
if(isset($data->id)){
	$id=$data->id;
    $parent_id=$data->parent_id;
}

@endphp
<div class="box box-danger">
    <div class="box-header with-border">
		<h3 class="box-title">{{$judul}}</h3>
    </div>
    <div class="box-body form-horizontal parent-category">
        <form method="post" action="{{route('catalog.category.proses')}}" id="fileinfo">
        	<input type="hidden" name="f_id" value="{{$id}}">
        	{{ csrf_field() }}
        	
        	<div class="form-group">
                <label class="col-sm-3 control-label">Kode Kategori</label>
                <div class="col-sm-6">
                    <input type="text" name="f_kodekategori" value="{{$data->code or ''}}" placeholder="Kode Kategori.." class="form-control" required>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-3 control-label">Nama Kategori</label>
                <div class="col-sm-6">
                    <input type="text" name="f_namakategori" value="{{$data->display_name or ''}}" placeholder="Nama Kategori.." class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Induk Kategori</label>
                <div class="col-sm-6">
                    <select name="f_indukkategori" class="form-control select2" required>
                        <option value="0">Tidak Memiliki Induk</option>
                        @foreach($category as $i=>$rows)
                        @php                        
                        if($rows->id==$parent_id){
	                        $a="selected";
	                    }else{
		                    $a="";
		                }
                        @endphp
                        	<option value="{{$rows->id}}" {{$a}}>{{$rows->display_name}}</option>
                        @endforeach                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Deskripsi</label>
                <div class="col-sm-6">
                	<textarea class="form-control"  name="f_deskripsikategori" placeholder="Deskripsi..">{{$data->desc or ''}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-md-offset-3">
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="box box-danger">
    <div class="box-header with-border">
		<h3 class="box-title">
			Daftar Kategori
		</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="alertBS"></div>
        <table class="table table-striped" id="daftar1">
            <thead>
            <tr>
                <th width="20">kode</th>
                <th width="100">Nama</th>
                <th width="100">Induk</th>
                <th width="150">Deksripsi</th>
                <th width="150">Aksi</th>
            </tr>
            </thead>
            <tbody>
            	@foreach($category as $i=>$rows)
            		<tr>
            			<td>{{$rows->code}}</td>
            			<td>{{$rows->display_name}}</td>
            			<td>{{$rows->parent_name}}</td>
            			<td>{{$rows->desc}}</td>
            			<td>
                            <div class="btn-group">
                                <a href="{{route('catalog.category')}}?id={{$rows->id}}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                <a href="{{route('catalog.category.delete')}}?f_id={{$rows->id}}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                            </div>
	                    </td>
            		</tr>
            	@endforeach
            </tbody>
        </table>
    </div>
<!-- /.box-body -->
</div>
</div>
s
@endsection
@push('scripts')
<script>
$('#daftar1').DataTable();
$('.parent-category').find(".select2").each(function(index){
    if($(this).data('select2')) {
        $(this).select2('destroy');
    } 
});
$(".select2").select2({
	placeholder:"Silahkan Pilih"
});
</script>
@endpush
