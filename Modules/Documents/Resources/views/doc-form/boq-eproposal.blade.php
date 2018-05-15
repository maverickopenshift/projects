<div class="form-group formerror formerror-doc_pr">
  {{-- <label for="prinsipal_st" class="col-sm-2 control-label"> PR</label> --}}
  <div class="col-sm-3">
    <div class="input-group">
      <input class="form-control no_pr" type="text" name="doc_pr" value="{{old('doc_pr',Helper::prop_exists($doc,'doc_pr'))}}" placeholder="Masukan No.PO" autocomplete="off">
      <span class="input-group-btn">
        <button class="btn btn-success cari-pr" type="button"><i class="glyphicon glyphicon-search"></i></button>
      </span>
    </div>
  </div>
  <span class="error error-pr text-danger"></span>
  <div class="col-sm-10 col-sm-offset-2">
    <div class="error error-doc_pr"></div>
  </div>
</div>
  <div class="row">
    <div class="col-md-4"><div id="jstree"></div></div>
    <div class="col-md-8"><div id="table-boq"></div></div>
  </div>
  <style type="text/css">
      #jstree{
          max-width: 90%;
      }

      #jstree a {
          white-space: normal !important;
          height: auto;
          padding: 1px 2px;
      }
  </style>
@push('scripts')
<script>
  $(document).ready(function(e){
    var pr = $('.no_pr').val()
    if(pr!=="" && typeof pr !== 'undefined'){
      $('.cari-pr').trigger('click');
    }
  });
  $(document).on('click', '.cari-pr', function(event) {
    event.preventDefault();
    /* Act on the event */
    $('#jstree').hide();
    $('#table-boq').html('');
    var pr = $('.no_pr').val(),error_po = $('.error-pr');
    error_po.html('<img src="{!!asset('/images/loader.gif')!!}" title="please wait..." width="25"/>');
    if(pr==""){
      error_po.html('No.PO harus diisi');
      return false;
    }
    else{
      $.ajax({
        url: '{!!route('doc.get-pr')!!}',
        type: 'GET',
        dataType: 'json',
        data: {pr_no:pr}
      })
      .done(function(response) {
        if(response.status=='success'){
          var __data = response.data;
          if(__data.length>0){
            onJsonOke(__data);
            $('#jstree').show();
            // $('input.no_po').val(pr);
            // $('.cari-po').trigger('click');
          }
          error_po.html('');
        }
        else{
          error_po.html('No.PO tidak ditemukan!');
        }
      }).error(function() {
        error_po.html('No.PO tidak ditemukan!');
      });
    }
  });
  function onJsonOke(data){
    $('#jstree')
    .on("changed.jstree", function (e, data) {
        if(data.selected.length) {
            //
        }
    })
    .jstree({
        'core' : {
            'data' : pushJson(data)
        }
    })
    .bind("ready.jstree", function (event, data) {
         $(this).jstree("open_all");
    });
  }
  function pushJson(data){
    var data__ = [];
    $.each(data,function(index, el) {
      var child = this.data;
      if(child && child.length>0 && this.type!='boq'){
        
        if(this.type=='unit_bisnis' || this.type=='unit_kerja'){
          var textnya = this.text;
        }
        else{
          var textnya = this.text+' <b><i>('+formatRupiah(this.total_nilai,this.ccq)+')</i></b>';
        }
        if(this.type=='lop'){
          var child_lop = child.data;
          var a_attr = {};
          // if(child_lop && child_lop.length>0){
            a_attr = {'data-json':encodeURI(JSON.stringify(child)),'class':'showtableboq'};
          // }
          data__.push({'text':textnya,'icon':'glyphicon glyphicon-file','children':pushJson(child),'a_attr':a_attr});
        }
        else{
          data__.push({'text':textnya,'children':pushJson(child)});
        }
      }
      else{
        //data__.push({'text':this.text});
      }
      
    });
    return data__;
  }
  $(document).on('click', '.showtableboq', function(event) {
    event.preventDefault();
    /* Act on the event */
    var data = $(this).data('json');
    data = JSON.parse(decodeURI(data));
    $('#table-boq').html('');
    var table  = '<table class="table table-condensed table-striped">';
        table += '<thead>';
        table += '<tr>';
        table += '<th>No.</th>';
        table += '<th>Designator</th>';
        table += '<th>Uraian</th>';
        table += '<th>Satuan</th>';
        table += '<th>Material</th>';
        table += '<th>Jasa</th>';
        table += '<th>Qty</th>';
        // table += '<th>Referensi</th>';
        table += '</tr>';
        table += '</thead>';
        table += '<tbody>';
        
    $.each(data,function(index, el) {
      table += '<tr>';
      table += '<td>'+(index+1)+'</td>';
      table += '<td>'+this.designator+'</td>';
      table += '<td>'+this.uraian+'</td>';
      table += '<td>'+this.satuan+'</td>';
      table += '<td>'+formatRupiah(parseInt(this.material))+'</td>';
      table += '<td>'+formatRupiah(parseInt(this.jasa))+'</td>';
      table += '<td>'+parseFloat(this.qty)+'</td>';
      // table += '<td>'+this.referensi+'</td>';
      table += '</tr>';
    });
    
        table += '</tbody>';
        table += '</table>';
    $('#table-boq').html(table);
  });
</script>
@endpush