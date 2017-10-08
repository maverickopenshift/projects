@extends('layouts.app')

@section('content')
<form method="post" enctype="multipart/form-data" action="#">
    {{ csrf_field() }}
<div class="box">
    <div class="box-header with-border border-bottom-red">
      <h3 class="box-title text-red">Data Entry</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif


          <div class="row">
            <div class="col-sm-6">
              <div  class="form-horizontal">
                <div class="form-group">
                  <label for="doc_title" class="col-sm-4 control-label">Judul {{$doc_type['title']}}</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="doc_title" name="doc_title" placeholder="Masukan Data" value="{{$data['doc_title']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_number" class="col-sm-4 control-label">Nomor {{$doc_type['title']}}</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="doc_number" value="{{$data['doc_number']}}" name="doc_number" placeholder="Masukan Data">
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_roles" class="col-sm-4 control-label">UBIS / AP in charge</label>
                  <div class="col-sm-8">
                    {!! Helper::select_ubis('id_roles',$data['id_roles']) !!}
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_mitra" class="col-sm-4 control-label">Pihak terkait / Mitra </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="doc_mitra" name="doc_mitra" placeholder="Masukan Data" value="{{$data['doc_mitra']}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="id_doc_cat" class="col-sm-4 control-label">Kategori</label>
                  <div class="col-sm-8">
                    {!! Helper::select_category('id_doc_cat',$data['id_doc_cat']) !!}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div  class="form-horizontal">
                <div class="form-group">
                  <label for="doc_desc" class="col-sm-4 control-label">Ringkasan isi perjanjian</label>
                  <div class="col-sm-8">
                    <textarea rows="8" class="form-control" id="doc_desc" name="inputisiperjanjian" placeholder="Masukan Data">{{$data['doc_desc']}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
    <div class="box-header with-border border-bottom-red">
      <h3 class="box-title text-red">File Upload</h3>
    </div>
    <div class="box-body">
          <div class="row">
            <div class="col-sm-6">
              <div  class="form-horizontal">
                @if ($doc_type->name=='kontrak' || $doc_type->name=='nota_kesepakatan' || $doc_type->name=='engagement_letter' || $doc_type->name=='engagement_letter')    
                <div class="form-group">
                  <label for="doc_startdate" class="col-sm-4 control-label">Tanggal Berlaku</label>
                  <div class="col-sm-8">
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" name="doc_startdate" id="doc_startdate" value="{{$data['doc_startdate']}}">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_enddate" class="col-sm-4 control-label">Tanggal Berakhir</label>
                  <div class="col-sm-8">
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" name="doc_enddate" id="doc_enddate" value="{{$data['doc_enddate']}}">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                  </div>
                </div>
                @endif
                <div class="form-group">
                  <label for="doc_keywords" class="col-sm-4 control-label">Keywords</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control tagsinput" value="{{$data['doc_keywords']}}" id="doc_keywords" name="doc_keywords" placeholder="key 1,key 2,key 3">
                  </div>
                </div>
                <div class="form-group">
                  <label for="doc_file" class="col-sm-4 control-label">Document</label>
                  <div class="col-sm-8">
                    <input type="file" class="form-control" id="doc_file" name="doc_file">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-12">
              <div class="pull-right">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </div>
          </div>
    </div>
<!-- /.box-body -->
</div>
</form>
@endsection
