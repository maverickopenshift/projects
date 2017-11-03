<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
        @if($doc_type['title']=="Turnkey" || $doc_type['title']=="SP")
          SOW,BOQ
        @else
          Daftar Harga satuan
        @endif
      </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="form-horizontal">
          <div class="form-group">
            <label for="nm_vendor" class="col-sm-2 control-label"><span class="text-red">*</span> Lingkup Pekerjaan</label>
            <div class="col-sm-10">
              <textarea class="form-control" cols="4" rows="4"></textarea>
            </div>
          </div>
          @if($doc_type['title']=="KHS")
          <div class="form-group top20">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> Daftar Harga Satuan</label>
            <div class="col-sm-10">
              <input type="file" name="daftar_harga" class="daftar_harga hide"/>
              <button class="btn btn-success upload-daftar_harga" type="button">Upload Daftar Harga</button>
              <span class="error error-daftar_harga text-danger"></span>
            </div>
          </div>
          <div class="parent-datatables-harga" style="display:none;">
            <table class="table table-condensed table-striped" id="datatablesHarga">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Item</th>
                    <th>Item</th>
                    <th>Satuan</th>
                    <th>MTU</th>
                    <th width="">Harga</th>
                    <th width="">Keterangan</th>
                    <th class="text-right"><button type="button" class="btn btn-success btn-xs" id="addRowHarga"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
                </tr>
                </thead>
            </table>
          </div>
          @endif
          @if($doc_type['title']=="Turnkey" || $doc_type['title']=="SP")
          <div class="form-group top20">
            <label for="prinsipal_st" class="col-sm-2 control-label"><span class="text-red">*</span> BoQ</label>
            <div class="col-sm-10">
              <input type="file" name="boq_file" class="boq_file hide"/>
              <button class="btn btn-success upload-boq" type="button">Upload BoQ</button>
              <span class="error error-boq text-danger"></span>
            </div>
          </div>
          <div class="parent-datatables" style="display:none;">
            <table class="table table-condensed table-striped" id="datatables">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Item</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>MTU</th>
                    <th width="">Harga</th>
                    <th width="">Harga Total</th>
                    <th width="">Keterangan</th>
                    <th class="text-right"><button type="button" class="btn btn-success btn-xs" id="addRow"><i class="glyphicon glyphicon-plus"></i> tambah</button></th>
                </tr>
                </thead>
            </table>
          </div>
          @endif
          @if($doc_type['title']=="SP")
            <div class="form-group">
              <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Import BoQ dari EPROPOSAL</label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input type="file" class="hide" name="legal_dokumen[][file]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="ttd_pihak2" class="col-sm-2 control-label"><span class="text-red">*</span>Lampiran Teknis</label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input type="file" class="hide" name="legal_dokumen[][file]">
                  <input class="form-control" type="text" disabled>
                  <span class="input-group-btn">
                    <button class="btn btn-default click-upload" type="button">Browse</button>
                  </span>
                </div>
              </div>
            </div>
          @endif
          {{-- @include('documents::partials.buttons') --}}
      </div>
    </div>
<!-- /.box-body -->
</div>
@push('scripts')
<script>
$(function() {
  $('.upload-boq').on('click', function(event) {
    /* Act on the event */
    event.stopPropagation();
    event.preventDefault();
    $('.error-boq').html('');
    var $file = $('.boq_file').click();
  });
  $('.boq_file').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();
    handleFileSelect(this.files[0]);
  });
});
var dataPapaParse;

function handleFileSelect(file) {

  Papa.parse(file, {
    header: true,
    dynamicTyping: true,
    complete: function(results) {
      //dataPapaParse = results;
      var fields = results.meta.fields;
      var fields_dec = ['KODE_ITEM','ITEM','QTY','SATUAN','MTU','HARGA','HARGA_TOTAL','KETERANGAN'];
      if(fields.length!==8 || JSON.stringify(fields_dec)!==JSON.stringify(fields)){
        $('.error-boq').html('Format CSV tidak valid');
        return false;
      }
      //console.log(JSON.stringify(results.data));
      $('.parent-datatables').show();
      $('#datatables').DataTable().destroy();
      var dtTB = $('#datatables').DataTable({
          pageLength: 25,
          data: results.data,
          scrollX   : true,
          dom:'lrtip',
          fixedColumns:   {
                leftColumns: 3,
                rightColumns:1
          },
          order : [[ 1, 'asc' ]],
          columns: [
              { data:null,orderable:false,searchable:false,width:40},
              { data: 'KODE_ITEM', name: 'KODE_ITEM',width:150 ,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input class="form-control" name="kode_item[]" value="'+data+'" />';
              }},
              { data: 'ITEM', name: 'ITEM',width:150,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input class="form-control" name="item[]" value="'+data+'" />';
              }},
              { data: 'QTY', name: 'QTY' ,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input style="width:50px;" class="form-control" name="qty[]" value="'+data+'" />';
              }},
              { data: 'SATUAN', name: 'SATUAN',orderDataType:"dom-text" ,render: function ( data, type, row ) {
                    return '<input style="width:100px;" class="form-control" name="satuan[]" value="'+data+'" />';
              }},
              { data: 'MTU', name: 'MTU',orderDataType:"dom-text" ,render: function ( data, type, row ) {
                    return '<input style="width:60px;" class="form-control" name="mtu[]" value="'+data+'" />';
              }},
              { data: 'HARGA', name: 'HARGA' ,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input style="width:100px;" class="form-control" name="harga[]" value="'+data+'" />';
              }},
              { data: 'HARGA_TOTAL', name: 'HARGA_TOTAL' ,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input  style="width:100px;" class="form-control" name="harga_total[]" value="'+data+'" />';
              }},
              { data: 'KETERANGAN',orderDataType:"dom-text", type: 'string', name: 'KETERANGAN' ,render: function ( data, type, row ) {
                    return '<input class="form-control" name="keterangan[]" value="'+data+'" />';
              }},
              { data:null,orderable:false,width:80,className:"text-center",searchable:false,render: function ( data, type, row ) {
                    return '<button type="button" class="btn btn-danger btn-xs delete-dttb"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
                }},
          ],
          columnDefs: [{
              "targets": 9,
              "data": null,
              "defaultContent": ""
          }
          ]
      });
      dtTB.on( 'order.dt search.dt', function () {
          dtTB.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
              cell.innerHTML = i+1;
          } );
      }).draw();
      $(document).on( 'click','#addRow', function () {
          var dataNew = {"KODE_ITEM":"","ITEM":"","QTY":"","SATUAN":"","MTU":"","HARGA":"","HARGA_TOTAL":"","KETERANGAN":""};
          //var dataNew = [null,null,null,null,null,null,null,null];
          dtTB.row.add( dataNew ).draw(false);
          dtTB.order([1, 'desc']).draw();
      });
      $(document).on( 'click', '.delete-dttb', function () {
        dtTB
            .row( $(this).parents('tr') )
            .remove()
            .draw();
      } );
    }
  });
}

//daftar harga
$(function() {
  $('.upload-daftar_harga').on('click', function(event) {
    /* Act on the event */
    event.stopPropagation();
    event.preventDefault();
    $('.error-daftar_harga').html('');
    var $file = $('.daftar_harga').click();
  });
  $('.daftar_harga').on('change', function(event) {
    event.stopPropagation();
    event.preventDefault();
    handleDaftarHargaFileSelect(this.files[0]);
  });
});


function handleDaftarHargaFileSelect(file) {

  Papa.parse(file, {
    header: true,
    dynamicTyping: true,
    complete: function(results) {
      //dataPapaParse = results;
      var fields = results.meta.fields;
      var fields_dec = ['KODE_ITEM','ITEM','SATUAN','MTU','HARGA','KETERANGAN'];
      if(fields.length!==6 || JSON.stringify(fields_dec)!==JSON.stringify(fields)){
        $('.error-daftar_harga').html('Format CSV tidak valid');
        return false;
      }
      //console.log(JSON.stringify(results.data));
      $('.parent-datatables-harga').show();
      $('#datatablesHarga').DataTable().destroy();
      var dtTB = $('#datatablesHarga').DataTable({
          pageLength: 25,
          data: results.data,
          scrollX   : true,
          dom:'lrtip',
          fixedColumns:   {
                leftColumns: 3,
                rightColumns:1
          },
          order : [[ 1, 'asc' ]],
          columns: [
              { data:null,orderable:false,searchable:false,width:40},
              { data: 'KODE_ITEM', name: 'KODE_ITEM',width:150 ,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input class="form-control" name="kode_item[]" value="'+data+'" />';
              }},
              { data: 'ITEM', name: 'ITEM',width:150,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input class="form-control" name="item[]" value="'+data+'" />';
              }},
              { data: 'SATUAN', name: 'SATUAN',orderDataType:"dom-text" ,render: function ( data, type, row ) {
                    return '<input style="width:100px;" class="form-control" name="satuan[]" value="'+data+'" />';
              }},
              { data: 'MTU', name: 'MTU',orderDataType:"dom-text" ,render: function ( data, type, row ) {
                    return '<input style="width:60px;" class="form-control" name="mtu[]" value="'+data+'" />';
              }},
              { data: 'HARGA', name: 'HARGA' ,orderDataType:"dom-text-numeric" ,render: function ( data, type, row ) {
                    return '<input style="width:100px;" class="form-control" name="harga[]" value="'+data+'" />';
              }},
              { data: 'KETERANGAN',orderDataType:"dom-text", type: 'string', name: 'KETERANGAN' ,render: function ( data, type, row ) {
                    return '<input class="form-control" name="keterangan[]" value="'+data+'" />';
              }},
              { data:null,orderable:false,width:80,className:"text-center",searchable:false,render: function ( data, type, row ) {
                    return '<button type="button" class="btn btn-danger btn-xs delete-dttb"><i class="glyphicon glyphicon-remove"></i> hapus</button>';
                }},
          ],
          columnDefs: [{
              "targets": 7,
              "data": null,
              "defaultContent": ""
          }
          ]
      });
      dtTB.on( 'order.dt search.dt', function () {
          dtTB.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
              cell.innerHTML = i+1;
          } );
      }).draw();
      $(document).on( 'click','#addRowHarga', function () {
          var dataNew = {"KODE_ITEM":"","ITEM":"","SATUAN":"","MTU":"","HARGA":"","KETERANGAN":""};
          //var dataNew = [null,null,null,null,null,null,null,null];
          dtTB.row.add( dataNew ).draw(false);
          dtTB.order([1, 'desc']).draw();
      });
      $(document).on( 'click', '.delete-dttb', function () {
        dtTB
            .row( $(this).parents('tr') )
            .remove()
            .draw();
      } );
    }
  });
}
</script>
@endpush
