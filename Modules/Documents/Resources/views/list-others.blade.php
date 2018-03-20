@extends('layouts.app')

@section('content')
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"></h3>

      <div class="box-tools pull-right">
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))

          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
          @endif
        @endforeach
      </div> <!-- end .flash-message -->
      <div class="table-kontrak">
        <div class="form-inline bottom25">
          <div class="form-group top10">
            <input style="width:290px;" type="text" class="form-control cari-judul" placeholder="Judul/Nomor Kontrak">
          </div>
          @if($user_type!='subsidiary')
            @role('admin')
            <div class="form-group top10">
              {!!Helper::select_all_divisi('divisi')!!}
            </div>
            @endrole
            <div class="form-group top10">
              {!!Helper::select_unit('unit_bisnis')!!}
            </div>
            <div class="form-group top10">
              {!! Helper::select_type2('doc_type') !!}
            </div>
          @endif
          <button type="button" class="btn btn-success search top10">Cari</button>
          <button type="button" class="btn btn-danger reset top10">Reset</button>
        </div>
      </div>
    </div>
<!-- /.box-body -->
</div>

<div class="modal modal-danger fade" id="modal-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this data</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline btn-delete" data-loading-text="Please wait..."><i class="glyphicon glyphicon-trash"></i> Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@push('scripts')
<script>
if(is_admin()){
  $(document).on('change', '#divisi', function(event) {
    event.preventDefault();
    /* Act on the event */
    var divisi = this.value;
    //if(unit!==""){
    $('#unit_bisnis').find('option').not('option[value=""]').remove();
      $.ajax({
        url: '{!!route('doc.get-unit')!!}',
        type: 'GET',
        dataType: 'json',
        data: {divisi: divisi}
      })
      .done(function(data) {
        if(data.length>0){
          $.each(data,function(index, el) {
            $('#unit_bisnis').append('<option value="'+this.id+'">'+this.title+'</option>');
          });
        }
      });
    //}
  });
  $(function(e){
    $('#unit_bisnis').find('option').not('option[value=""]').remove();
    if($('#divisi').val()!==""){
      $('#divisi').change();
    }
  });
}
$.fn.tableOke = function(options) {
    options.tableAttr = this;
    options.tableClass = 'table table-condensed table-striped';
    options.tableAttr.css({position:'relative'});
    options.withNumber = true,
    options.emptyMessage = 'No data available!';
    options.loadingImg = '/images/loader.gif';
    options.trLoadingClass='row-loading';
    options.qAttr = options.tableAttr.find('.cari-judul');
    options.unitAttr = options.tableAttr.find('#unit_bisnis');
    options.divisiAttr = options.tableAttr.find('#divisi');
    options.jenisAttr = options.tableAttr.find('#doc_type');
    options.q = options.qAttr.val();
    options.divisi = options.divisiAttr.val();
    options.unit = options.unitAttr.val();
    options.cssLoading='background-color: rgba(255,255,255,0.5);position: absolute;width: 100%;height: 100%;background-image: url('+options.loadingImg+');background-position: center center;background-repeat: no-repeat;z-index:1000;';
    options.loading = 'loading-me';
    options.loadingHtml = '<div class="'+options.loading+'" style="'+options.cssLoading+'"></div>';
    options.renderHeader = function(){
      var header  = '<thead>';
      header += '<tr>';
      if(options.withNumber){
          header += '<th>No.</th>';
      } 
      $.each(options.data,function(index, el) {
        header += '<th>'+this.title+'</th>';
      });    
      header += '</tr>';
      header += '</thead>';
        
      return header;
    }
    options.count_td = function(){
      var tr_clone = $(options.renderHeader);
      var tr = tr_clone.find('tr');
      var th = tr.find('th');
      return th.length;
    };
    options.parseHTML = function(html,data){
      var regExp = /{#([^)]+)#}/g;
      // var match = [];
      var matches = regExp.exec(html);
      // while ((matches = regExp.exec(html)) != null) {
      //   alert(matches[1]);
      // }
      // while (matches != null) {
      //     match.push(matches[1]);
      //     matches = regExp.exec(html);
      // }
      //console.log(matches);
      //matches[1] contains the value between the parentheses
      var mystring = html;
      // console.log(JSON.stringify(match));
      if(matches!==null){
        mystring = mystring.replace('{#'+matches[1]+'#}', data[matches[1]]);
      }
      return mystring;
    }
    options.splitName = function(data,val){
      var str = val;
      str = str.split('.');
      var str_t = 'data';
      var name = '';
      $.each(str,function(index, el) {
        if(this!==undefined){
          name += '[\''+this+'\']';
        }
      });
      return eval(str_t+name);
      //console.log(str_t+name);
    }
    var tbl_resp = $('<div/>',{class:'table-responsive'});
    options.tableHTML=$('<table/>', {class: options.tableClass+' tableLaravel'});
    options.tableHTML.append(options.renderHeader()).append('<tbody></tbody>');
    options.tableAttr.append(tbl_resp.append(options.tableHTML));
    options.tableAttr.prepend(options.loadingHtml);
    options.renderData = function(data,no){
      var render = '<tr data-total-child="'+data['total_child']+'" data-id="'+data['id']+'" class="row-parent row-'+data['id']+'">';
      var expandable = '';
      if(parseInt(data['total_child'])>0){
        var expandable = 'class="td-expand plus"';
      }
      if(options.withNumber){
          render += '<td>'+(no+1)+'</td>';
      } 
      $.each(options.data,function(index, el) {
        if(this.name!==false && this.html===undefined){
          var rend_dt = options.splitName(data,this.name);
          var rend_exp = (index==0)?expandable:'';
          render += '<td '+rend_exp+'>'+((rend_dt==null || rend_dt===undefined)?'-':rend_dt)+'</td>';
        }
        else{
          if(this.name===false && this.html!==undefined){
            var rend_exp = (index==0)?expandable:'';
            render += '<td '+rend_exp+'>'+options.parseHTML(this.html,data)+'</td>';
          }
          else{
            render += '<td></td>';
          }
        }
        
      });    
      render += '</tr>';
        
      return render;
    }
    options.renderDataChild = function(data,no,child){
      var render = '<tr data-total-child="'+data['total_child']+'" data-id="'+data['id']+'" class="row-parent-'+data['doc_parent_id']+' row-child-'+child+' row-'+data['id']+'">';
      var expandable = '';
      if(parseInt(data['total_child'])>0){
        var expandable = ' td-expand plus ';
      }
      if(options.withNumber){
          render += '<td></td>';
      } 
      $.each(options.data,function(index, el) {
        if(this.name!==false && this.html===undefined){
          var class_a = '';
          if(index==0){
            if(data['doc_type']=='sp'){child = 2;}
            class_a = 'class="child-'+child+' '+expandable+'"';
          }
          var rend_dt = options.splitName(data,this.name);
          render += '<td '+class_a+'>'+((rend_dt==null || rend_dt===undefined)?'-':rend_dt)+'</td>';
        }
        else{
          var class_a = '';
          if(index==0){
            if(data['doc_type']=='sp'){child = 2;}
            class_a = 'class="child-'+child+' '+expandable+'"';
          }
          if(this.name===false && this.html!==undefined){
            render += '<td '+class_a+'>'+options.parseHTML(this.html,data)+'</td>';
          }
          else{
            render += '<td '+class_a+'></td>';
          }
        }
        
      });    
      render += '</tr>';
        
      return render;
    }
    options.renderEmpty = function(){
      var renderEmp = '<tr class="empty-data">';
      var countColspan = options.data.length;
      if(options.withNumber){
          countColspan = countColspan+1;
      } 
      renderEmp += '<td style="text-align:center;" colspan="'+countColspan+'">'+options.emptyMessage+'</td>';
      renderEmp += '</tr>';
        
      return renderEmp;
    }
    options.renderLoading = function(id){
      var renderEmp = '<tr class="'+options.trLoadingClass+' row-'+id+'">';
      var countColspan = options.data.length;
      if(options.withNumber){
          countColspan = countColspan+1;
      } 
      renderEmp += '<td style="text-align:center;" colspan="'+countColspan+'"><img style="width: 22px;" src="'+options.loadingImg+'" title="please wait..."/></td>';
      renderEmp += '</tr>';
        
      return renderEmp;
    }
    options.pagination = function(data){
      var render_pg='';
      var url = '&limit='+options.limit+'&q='+options.q+'&divisi='+options.divisi+'&unit='+options.unit+'&jenis='+options.jenis;
      if(data.last_page>1){
        render_pg += '<ul class="pagination">';
          if(data.current_page != 1 && data.last_page >=5){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page=1'+url+'>&laquo;</a>';
            render_pg += '</li>';
          }
          else{
              render_pg += '<li class="disabled">';
              render_pg += '<a href="#">&laquo;</a>';
              render_pg += '</li>';
          }
          if(data.current_page != 1){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page='+(data.current_page-1)+url+'>Prev</a>';
            render_pg += '</li>';
          }          
          else{
              render_pg += '<li class="disabled">';
              render_pg += '<a href="#">Prev</a>';
              render_pg += '</li>';
          }
          for (var i = Math.max((data.current_page-2), 1); i <= Math.min(Math.max((data.current_page-2), 1)+4,data.last_page); i++) {
            render_pg += '<li class="'+((data.current_page==i)?' active':' ')+'">';
            render_pg += '<a class="'+((data.current_page==i)?'disabled':' ')+'" href='+options.url+'?page='+(i)+url+'>'+i+'</a>';
            render_pg += '</li>';
          }
          if(data.current_page != data.last_page){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page='+(data.current_page+1)+url+'>Next</a>';
            render_pg += '</li>';
          }
          else{
            render_pg += '<li class="disabled">';
            render_pg += '<a href="#">Next</a>';
            render_pg += '</li>';
          }
          if(data.current_page != data.last_page && data.last_page>=5){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page='+(data.last_page)+url+'>&raquo;</a>';
            render_pg += '</li>';
          }
          else{
            render_pg += '<li class="disabled">';
            render_pg += '<a href="#">&raquo;</a>';
            render_pg += '</li>';
          }
        render_pg += '</ul>';
      }  
      return render_pg;
    }
    options.getParams = function(name, def__,url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return (def__==undefined)?null:def__;
        if (!results[2]) return (def__==undefined)?'':def__;
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
    options.page = options.getParams('page',options.page);
    options.limit = options.getParams('limit',options.limit);
    options.q = options.getParams('q',options.q);
    options.unit = options.getParams('unit',options.unit);
    options.divisi = options.getParams('divisi',options.divisi);
    options.jenis = options.getParams('jenis',options.jenis);
    options.ajaxPro = function(){
      $.ajax({
        url: options.url,
        type: 'GET',
        dataType: 'json',
        data : {
          page  : options.page,
          q : (options.q!==undefined)?options.q:'',
          divisi : (options.divisi!==undefined)?options.divisi:'',
          unit : (options.unit!==undefined)?options.unit:'',
          jenis : (options.jenis!==undefined)?options.jenis:'',
          limit : options.limit
        }
      })
      .done(function(data) {
        options.unitAttr.val(options.unit);
        options.jenisAttr.val(options.jenis);
        if(data.data.length>0){
          options.tableAttr.find('.empty-data').remove();
          var render;
          $.each(data.data,function(index, el) {
            render += options.renderData(this,index);
          }); 
          var wait_render = function() {
            options.tableAttr.find('tbody').html('');
            options.tableAttr.find('tbody').append(render);
            options.tableAttr.find('.pagination').remove();
            
            return options.tableAttr.append(options.pagination(data));
          };
          $.when( wait_render() ).done(function() {
            yellowBro(options.q);
            // var tr = options.tableAttr.find('tbody>tr.row-parent');
            // $.each(tr,function(index, el) {
            //     var row_id = $(this).data('id');
            //     var row_class = $(this).attr('class');
            //     // console.log(row_id+' - '+row_class);
            //     if(parseInt($(this).data('total-child'))>0){
            //       options.ajaxChild(1,row_id,$(this));
            //     }
            // });
            
          });
        }
        else{
          options.tableAttr.find('tbody').html('');
          options.tableAttr.find('tbody').append(options.renderEmpty);
          options.tableAttr.find('.pagination').remove();
        }
        options.qAttr.val(options.q);
        options.tableAttr.find('.'+options.loading).remove();
      });
    }
    options.ajaxChild = function(child,parent_id,attr){
      var tr_id = attr.data('id');
      attr.parent().find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
      attr.after(options.renderLoading(tr_id));
      attr.find('td.td-expand').removeClass('minus').addClass('plus');
      $.ajax({
        url: options.url,
        type: 'GET',
        dataType: 'json',
        data : {
          child     : child,
          parent_id : parent_id,
          q : (options.q!==undefined)?options.q:'',
          divisi : (options.divisi!==undefined)?options.divisi:'',
          unit : (options.unit!==undefined)?options.unit:'',
          jenis : (options.jenis!==undefined)?options.jenis:'',
        }
      })
      .done(function(data) {
          if(data.data.length>0){
            var render = '';
            $.each(data.data,function(index, el) {
              render += options.renderDataChild(this,index,child);
            }); 
            
            var wait_render2 = function() {
                return attr.after(render);
            };
            $.when( wait_render2() ).done(function() {
              attr.parent().find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
              attr.find('td.td-expand').removeClass('plus').addClass('minus');
              yellowBro(options.q);
              // var tr = options.tableAttr.find('tbody>tr.row-child-1');
              // $.each(tr,function(index, el) {
              //     var row_id = $(this).data('id');
              //     var row_class = $(this).attr('class');
              //     if(parseInt($(this).data('total-child'))>0){
              //     console.log(row_id+' - '+row_class+' - '+$(this).data('total-child'));
              //       options.ajaxChild2(2,row_id,$(this));
              //     }
              // });
            });
          }
          attr.parent().find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
      });
    }
    options.ajaxPro();
    $(options.tableAttr).on('click','.pagination>li>a', function(event) {
      event.preventDefault();
      /* Act on the event */
      if(!$(this).hasClass('disabled')){
        var urls = $(this).attr('href');
        options.page = options.getParams('page',options.page,urls);
        options.limit = options.getParams('limit',options.limit,urls);
        options.q = options.getParams('q',options.q,urls);
        window.history.pushState("", "", urls);
        options.tableAttr.prepend(options.loadingHtml);
        options.ajaxPro();
      }
    });
    $(options.tableAttr).on('click','.search', function(event) {
      event.preventDefault();
      /* Act on the event */
        options.page = 1;
        options.limit = options.getParams('limit',options.limit,urls);
        // options.q = options.getParams('q',options.q,urls);
        // options.divisi = options.getParams('divisi',options.divisi,urls);
        // options.unit = options.getParams('unit',options.unit,urls);
        options.tableAttr.prepend(options.loadingHtml);
        options.q = options.qAttr.val();
        options.divisi = options.divisiAttr.val();
        options.unit = options.unitAttr.val();
        options.jenis = options.jenisAttr.val();
        var urls = options.url+'?page='+options.page+'&limit='+options.limit+'&q='+options.q+'&divisi='+options.divisi+'&unit='+options.unit+'&jenis='+options.jenis;
        window.history.pushState({}, "", urls);
        options.ajaxPro();
    });
    $(options.tableAttr).on('click','.reset', function(event) {
      event.preventDefault();
      /* Act on the event */
        options.page = 1;
        options.tableAttr.prepend(options.loadingHtml);
        options.q = "";
        options.divisi = "";
        options.unit = "";
        options.jenis = "";
        $('#unit_bisnis').find('option').not('option[value=""]').remove();
        options.qAttr.val('');
        options.divisiAttr.val('');
        options.unitAttr.val('');
        options.jenisAttr.val('');
        window.history.pushState({}, "", options.url);
        options.ajaxPro();
    });
    $(options.tableAttr).on('click','.td-expand.plus', function(event) {
      event.preventDefault();
      /* Act on the event */
      var td = $(this);
      var tr_id = td.parent().data('id');
      var tr = td.parent();
      var table = tr.parent();
      var child_set = 1;
      if(td.hasClass('child-1')){
        child_set = 2;
      }
      else if(td.hasClass('child-2')){
        child_set = 3;
      }
      var count_expand = table.find('.row-parent-'+tr_id);
      table.find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
      td.parent().after(options.renderLoading(tr_id));
      if(count_expand.length>0){
        $.each(count_expand,function(index, el) {
          var get_tr = $(this);
          if(parseInt(get_tr.data('total-child'))>0){
            var new_tr = get_tr.find('.td-expand');
            if(new_tr.hasClass('minus')){
              //get_tr.find('.td-expand').trigger('click');
            }
            else if(new_tr.hasClass('plus')){
              var check = get_tr.parent().find('.row-parent-'+get_tr.data('id'));
              if(check.length>0){
                //get_tr.find('.td-expand').trigger('click');
              }
            }
          }
          get_tr.show();
        });
        table.find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
        td.removeClass('plus').addClass('minus');
      }
      else{
        $.each(tr,function(index, el) {
            var row_id = $(this).data('id');
            var row_class = $(this).attr('class');
            // console.log(row_id+' - '+row_class);
            if(parseInt($(this).data('total-child'))>0){
              options.ajaxChild(child_set,row_id,$(this));
            }
        });
      }
    });
    $(options.tableAttr).on('click','.td-expand.minus', function(event) {
      event.preventDefault();
      /* Act on the event */
      var td = $(this);
      var tr_id = td.parent().data('id');
      var tr = td.parent();
      var table = tr.parent();
      var count_expand = table.find('.row-parent-'+tr_id);
      table.find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
      td.parent().after(options.renderLoading(tr_id));
      if(count_expand.length>0){
        $.each(count_expand,function(index, el) {
          var get_tr = $(this);
          if(parseInt(get_tr.data('total-child'))>0){
            var new_tr = get_tr.find('.td-expand');
            if(new_tr.hasClass('minus')){
              get_tr.find('.td-expand').trigger('click');
            }
          }
          get_tr.hide();
        });
        table.find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
        td.removeClass('minus').addClass('plus');
      }
    });
    return this;
}
$(function () {
  var doc_type = '{!!$doc_status!!}';
  if(doc_type!=='draft'){
    var opt_data = [
      { name : 'title' , title  : 'Judul - No Kontrak',orderable:true},
      { name : 'sup_name' , title  : 'Vendor',orderable:true},
      { name : 'status' , title  : 'Status',orderable:true},
      { name : 'jenis.type.title' , title  : 'Type',orderable:true},
      { name : 'link' , title  : 'Action'},
    ];
  }
  else{
    var opt_data = [
      { name : 'title' , title  : 'Judul - No Kontrak',orderable:true},
      { name : 'sup_name' , title  : 'Vendor',orderable:true},
      { name : 'jenis.type.title' , title  : 'Type',orderable:true},
      { name : 'link' , title  : 'Action'},
    ];
  }
  var options = {
    url : '{!!route('doc',['status'=>$doc_status])!!}',
    with_number : true,
    data : opt_data,
    page : 1,
    limit : 25,
    q : '',
  };
  var tbl = $('.table-kontrak').tableOke(options);
});
$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});
function yellowBro(string){
  if(string!=""){
    $('.table-kontrak').find(':contains('+string+')').each(function(){
     if($(this).children().length < 1) {
       //var strs = $(this).text().toUpperCase();
       var strings = string.toUpperCase();
       $(this).html( 
             $(this).text().replace(
                 new RegExp(strings, "g")
                 ,'<span style="background-color:yellow;">'+strings+'</span>' 
            )  
        ) 
     }
    });
  }
}
$(document).on('click', '.btn-reject', function(event) {
  event.preventDefault();
  /* Act on the event */
  swal(
    'Dokumen Anda ditolak!',
    $(this).data('msg'),
    'error'
  );
});

var modalDelete = $('#modal-delete');
modalDelete.on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id')
    var modal = $(this)
    var btnDelete = modal.find('.btn-delete')
    btnDelete.attr('data-id',button.data('id'))
    btnDelete.attr('data-type',button.data('type'))
    btnDelete.button('reset')
})

$(document).on('click','.btn-delete',function (event) {
    event.preventDefault();
    var btnDelete = $(this)
    btnDelete.button('loading')
    
    $.ajax({
        url: '{!! route('doc.hapus') !!}',
        type: 'post',
        dataType: 'JSON',
        data: {_token:'{!! csrf_token() !!}',id:$(this).attr('data-id')},
        success: function( _response ){
            location.reload(); 
            modalDelete.modal('hide')
        },
        error: function( _response ){
            modalDelete.modal('hide')
        }
    });
})
</script>
@endpush
