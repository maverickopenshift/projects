@extends('layouts.app')

@section('content')
<form action="#" data-action="{{$data_action}}" class="{{$data_class}}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <div class="alertBS"></div>
          <div class="form-horizontal">
              <div class="form-group">
                <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Pilih Type Template</label>
                <div class="col-sm-10">
                  <input type="hidden" class="form-control" name="id"  value="{{old('id',Helper::prop_exists($data,'id'))}}"  placeholder="Masukan Kode Template" autocomplete="off">
                  @if($data_class=='form-add')
                  {!! Helper::select_type('type',Helper::prop_exists($data,'id_doc_type')) !!}
                  <div class="error error-type"></div>
                  @else
                  <span>{{ Helper::prop_exists($data,'title_type') }}</span>
                  @endif
                </div>
              </div>
          </div>
          <div class="form-horizontal">
              <div class="form-group">
                <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Pilih Jenis Template</label>
                <div class="col-sm-10">
                  @if($data_class=='form-add')
                  {!! Helper::select_category2('category',Helper::prop_exists($data,'id_doc_category')) !!}
                  <div class="error error-category"></div>
                  @else
                  <span>{{ Helper::prop_exists($data,'title') }}</span>
                  @endif
                </div>
              </div>
          </div>
          <div class="form-horizontal">
              <div class="form-group">
                <label for="bdn_usaha" class="col-sm-2 control-label"><span class="text-red">*</span> Kode Template</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="kode"  value="{{old('kode',Helper::prop_exists($data,'kode'))}}"  placeholder="Masukan Kode Template" autocomplete="off">
                  <div class="error error-kode"></div>
                </div>
              </div>
          </div>

          <div class="form-horizontal" style="display:none">
              <table class="table table-bordered table-me">
                <thead>
                <tr>
                  <th width="40">No.</th>
                  <th width="100">Pasal</th>
                  <th width="250">Judul</th>
                  <th>Isi</th>
                  <th  width="70"><button type="button" class="btn btn-success btn-xs add-row"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
                </tr>
              </thead>
              <tbody>
                @if ($data_class=='form-edit')
                  @foreach ($data_detail as $key => $value)
                  <tr>
                      <td>{{$key+1}}</td>
                      <td><input type="text" class="form-control" value="{{$value['name']}}" name="pasal[]" autocomplete="off"></td>
                      <td><input type="text" class="form-control" value="{{$value['title']}}" name="judul[]" autocomplete="off"></td>
                      <td><textarea name="isi[]" class="editor" id="editor{{$key+1}}">{{$value['desc']}}</textarea></td>
                      <td class="action"></td>
                  </tr>
                  @endforeach
                @else
                    <tr>
                        <td>1</td>
                        <td><input type="text" class="form-control" name="pasal[]" autocomplete="off"></td>
                        <td><input type="text" class="form-control" name="judul[]" autocomplete="off"></td>
                        <td><textarea name="isi[]" class="editor" id="editor1"></textarea></td>
                        <td class="action"></td>
                    </tr>
                @endif
              </tbody>
              </table>
          </div>
          <div class="form-group text-center top50">
            <a href="{{route('doc.template')}}" class="btn btn-warning" style="padding:5px 20px;font-weight:bold;font-size:16px;margin-right:10px">BATAL</a>
            <button type="submit" class="btn btn-success btn-save" data-loading-text="Please wait..." style="padding:5px 20px;font-weight:bold;font-size:16px;">SIMPAN</button>
          </div>
      </div>
  <!-- /.box-body -->
  </div>
</form>
@endsection
@push('scripts')
  <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
  <script>
    $(function(){
        $('.editor').each(function(e){
            CKEDITOR.replace( this.id);
        });
    });
    $(document).on('click', '.add-row', function(event) {
      event.preventDefault();
      var btn_del = '<button type="button" class="btn btn-danger btn-xs delete-row"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
      /* Act on the event */
      var $this = $('.table-me');
      var row = $this.find('tbody>tr');
      var new_row = row.eq(0).clone();
      var mdf_new_row = new_row.find('td');
      mdf_new_row.eq(0).html(row.length+1);
      mdf_new_row.eq(1).find('input').val('');
      mdf_new_row.eq(1).find('.error').remove();
      mdf_new_row.eq(2).find('input').val('');
      mdf_new_row.eq(2).find('.error').remove();
      mdf_new_row.eq(3).html('');
      mdf_new_row.eq(3).find('.error').remove();
      var id_editor = 'editor'+(row.length+1);
      mdf_new_row.eq(3).html('<textarea name="isi[]" class="editor" id="'+id_editor+'"></textarea>');
      $this.find('tbody').append(new_row);
      var row = $this.find('tbody>tr');
      $.each(row,function(index, el) {
        var mdf = $(this).find('.action');
        if(row.length==1){
          mdf.html('');
        }
        else{
          mdf.html(btn_del);
        }
      });
      CKEDITOR.replace(id_editor);
    });
    $(document).on('click', '.delete-row', function(event) {
      $(this).parent().parent().remove();
      var $this = $('.table-me');
      var row = $this.find('tbody>tr');
      $.each(row,function(index, el) {
        var mdf = $(this).find('.action');
        if(row.length==1){
          mdf.html('');
        }
      });
    });
    $(document).on('submit','.form-add',function (event) {
        event.preventDefault();
        var formMe = $(this)
        var attErrorType = formMe.find('.error-type')
        attErrorType.html('')
        formMe.find('.alertBS').html('')
        var attErrorCat = formMe.find('.error-category')
        attErrorCat.html('')
        formMe.find('.error').html('')
        var btnSave = formMe.find('.btn-save')
        btnSave.button('loading')
        $.ajax({
            url: formMe.data('action'),
            type: 'post',
            data: formMe.serialize(), // Remember that you need to have your csrf token included
            dataType: 'json',
            success: function( _response ){
                // Handle your response..
                console.log(_response)
                if(_response.errors){
                    if(_response.errors.type){
                        attErrorType.html('<span class="text-danger">'+_response.errors.type+'</span>');
                    }
                    if(_response.errors.category){
                        attErrorCat.html('<span class="text-danger">'+_response.errors.category+'</span>');
                    }
                    if(_response.errors.error){
                        alertBS2(_response.errors.error,'danger');
                    }
                    var $this = $('.table-me');
                    var row = $this.find('tbody>tr');
                    $.each(row,function(index, el) {
                      var mdf = $(this).find('td');
                      if(_response.errors["pasal."+index]){
                        mdf.eq(1).append('<div class="error text-danger">'+_response.errors["pasal."+index]+'</div>')
                      }
                      if(_response.errors["judul."+index]){
                        mdf.eq(2).append('<div class="error text-danger">'+_response.errors["judul."+index]+'</div>')
                      }
                      if(_response.errors["isi."+index]){
                        mdf.eq(3).append('<div class="error text-danger">'+_response.errors["isi."+index]+'</div>')
                      }
                    });
                }
                else{
                    window.location = '{!!route('doc.template')!!}';
                }
                btnSave.button('reset')
            },
            error: function( _response ){
                // Handle error
                btnSave.button('reset')
                $('#form-modal').modal('hide')
                alertBS('Something wrong, please try again','danger')
            }
        });
    })

    $(document).on('submit','.form-edit',function (event) {
        event.preventDefault();
        var formMe = $(this)
        var attErrorKode = formMe.find('.error-kode')
        attErrorKode.html('')
        formMe.find('.alertBS').html('')
        formMe.find('.error').html('')
        var btnSave = formMe.find('.btn-save')
        btnSave.button('loading')
        $.ajax({
            url: formMe.data('action'),
            type: 'get',
            data: formMe.serialize(), // Remember that you need to have your csrf token included
            dataType: 'json',
            success: function( _response ){
                // Handle your response..
                console.log(_response)
                if(_response.errors){
                    if(_response.errors.kode){
                        attErrorKode.html('<span class="text-danger">'+_response.errors.kode+'</span>');
                    }
                    if(_response.errors.error){
                        alertBS2(_response.errors.error,'danger');
                    }
                    // var $this = $('.table-me');
                    // var row = $this.find('tbody>tr');
                    // $.each(row,function(index, el) {
                    //   var mdf = $(this).find('td');
                    //   if(_response.errors["pasal."+index]){
                    //     mdf.eq(1).append('<div class="error text-danger">'+_response.errors["pasal."+index]+'</div>')
                    //   }
                    //   if(_response.errors["judul."+index]){
                    //     mdf.eq(2).append('<div class="error text-danger">'+_response.errors["judul."+index]+'</div>')
                    //   }
                    //   if(_response.errors["isi."+index]){
                    //     mdf.eq(3).append('<div class="error text-danger">'+_response.errors["isi."+index]+'</div>')
                    //   }
                    // });
                }
                else{
                    window.location = '{!!route('doc.template')!!}';
                }
                btnSave.button('reset')
            },
            error: function( _response ){
                // Handle error
                btnSave.button('reset')
                $('#form-modal').modal('hide')
                alertBS('Something wrong, please try again','danger')
            }
        });
    })
  </script>
@endpush
