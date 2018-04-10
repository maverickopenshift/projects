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
        <form method="get" action="#" class="form-search form-inline bottom25">
          <input type="hidden" name="page" class="page" value="{{$form['page']}}">
          <input type="hidden" name="limit" class="limit" value="{{$form['limit']}}">
          <div class="form-group top10">
            <input style="width:290px;" name="q" type="text" class="form-control cari-judul" placeholder="Judul/Nomor Kontrak" value="{{$form['q']}}">
          </div>    
          @if($user->pegawai_type!='subsidiary')
          <div class="form-group top10">
            {!!Helper::select_all_divisi('divisi',Laratrust::hasRole('monitor')?null:$user->divisi)!!}
          </div>
          <div class="form-group top10">
            @if(!empty($form['unit_bisnis']))
              {!!Helper::select_unit_bisnis('unit_bisnis',$form['unit_bisnis'],$user->divisi)!!}
            @else
              <select class="form-control" name="unit_bisnis" id="unit_bisnis">
                <option value="">Pilih Unit Bisnis</option>
              </select>
            @endif
          </div>
          <div class="form-group top10">
          @if(!empty($form['unit_kerja']))
            {!!Helper::select_unit_kerja('unit_kerja',$form['unit_kerja'],$form['unit_bisnis'])!!}
          @else
            <select class="form-control" name="unit_kerja" id="unit_kerja">
              <option value="">Pilih Unit Kerja</option>
            </select>
          @endif
          </div>
          @else
            <input type="hidden" name="divisi">
            <input type="hidden" name="unit_bisnis">
            <input type="hidden" name="unit_kerja">
          @endif
          <div class="form-group top10">
            {!! Helper::select_type2('jenis',$form['jenis']) !!}
          </div>
          <div class="form-group top10">
            <select class="form-control" id="doc_signing" name="open">
              <option value="">Pilih Status</option>
              <option value="1" {!!$form['open']=='1'?'selected':''!!}>Open</option>
              <option value="2" {!!$form['open']=='2'?'selected':''!!}>Close</option>
            </select>
          </div>
          <div class="form-group top10">
            <select class="form-control" id="doc_range" name="range">
              <option value="">Pilih Range</option>
              <option value="1" {!!$form['range']=='1'?'selected':''!!}>Bulan Ini</option>
              <option value="3" {!!$form['range']=='3'?'selected':''!!}>3 Bulan</option>
              <option value="6" {!!$form['range']=='6'?'selected':''!!}>6 Bulan</option>
            </select>
          </div>
          <div class="form-group top10">
            <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" id="doc_daritanggal" name="dari" placeholder="Dari Tanggal.." autocomplete="off" value="{{$form['dari']}}">
            </div>
          </div>

          <div class="form-group top10">
            <div class="input-group date" data-provide="datepicker">
              <div class="input-group-addon">
                <span class="fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control" id="doc_sampaitanggal" name="sampai" placeholder="Sampai Tanggal.." autocomplete="off" value="{{$form['sampai']}}">
            </div>
          </div>

          <button type="submit" class="btn btn-success search top10">Cari</button>
          <button type="button" class="btn btn-danger reset top10">Reset</button>
        </form>
      </div>
    </div>
<!-- /.box-body -->
</div>
@endsection
@push('scripts')
<script>
if(is_admin()){
  // $(document).on('change', '#divisi', function(event) {
  //   event.preventDefault();
  //   /* Act on the event */
  //   var divisi = this.value;
  //   //if(unit!==""){
  //   $('#unit_bisnis').find('option').not('option[value=""]').remove();
  //     $.ajax({
  //       url: '{!!route('doc.get-unit')!!}',
  //       type: 'GET',
  //       dataType: 'json',
  //       data: {divisi: divisi}
  //     })
  //     .done(function(data) {
  //       if(data.length>0){
  //         $.each(data,function(index, el) {
  //           $('#unit_bisnis').append('<option value="'+this.id+'">'+this.title+'</option>');
  //         });
  //       }
  //     });
  //   //}
  // });
  // $(function(e){
  //   $('#unit_bisnis').find('option').not('option[value=""]').remove();
  //   if($('#divisi').val()!==""){
  //     $('#divisi').change();
  //   }
  // });
}

$.fn.tableOke = function(options) {
    options.tableAttr = this;
    options.tableClass = 'table table-condensed table-striped';
    options.tableAttr.css({position:'relative'});
    options.withNumber = true,
    options.emptyMessage = 'No data available!';
    options.loadingImg = '/images/loader.gif';
    options.trLoadingClass='row-loading';
    options.searchUrl = '';
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
      if(data.last_page>1){
        render_pg += '<ul class="pagination">';
          if(data.current_page != 1 && data.last_page >=5){
            render_pg += '<li>';
            render_pg += '<a href="#" data-page="1">&laquo;</a>';
            render_pg += '</li>';
          }
          else{
              render_pg += '<li class="disabled">';
              render_pg += '<a href="#">&laquo;</a>';
              render_pg += '</li>';
          }
          if(data.current_page != 1){
            render_pg += '<li>';
            render_pg += '<a href="#" data-page='+(data.current_page-1)+'>Prev</a>';
            render_pg += '</li>';
          }          
          else{
              render_pg += '<li class="disabled">';
              render_pg += '<a href="#">Prev</a>';
              render_pg += '</li>';
          }
          for (var i = Math.max((data.current_page-2), 1); i <= Math.min(Math.max((data.current_page-2), 1)+4,data.last_page); i++) {
            render_pg += '<li class="'+((data.current_page==i)?' active':' ')+'">';
            render_pg += '<a class="'+((data.current_page==i)?'disabled':' ')+'" href="#" data-page='+(i)+'>'+i+'</a>';
            render_pg += '</li>';
          }
          if(data.current_page != data.last_page){
            render_pg += '<li>';
            render_pg += '<a href="#" data-page='+(data.current_page+1)+'>Next</a>';
            render_pg += '</li>';
          }
          else{
            render_pg += '<li class="disabled">';
            render_pg += '<a href="#">Next</a>';
            render_pg += '</li>';
          }
          if(data.current_page != data.last_page && data.last_page>=5){
            render_pg += '<li>';
            render_pg += '<a href="#" data-page='+(data.last_page)+'>&raquo;</a>';
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
    options.ajaxPro = function(){
      $.ajax({
        url: options.url+"?"+options.searchUrl,
        type: 'GET',
        cache: false,
        dataType: 'json'
      })
      .done(function(data) {
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
        options.tableAttr.find('.'+options.loading).remove();
      });
    }
    options.ajaxChild = function(child,parent_id,attr){
      var tr_id = attr.data('id');
      attr.parent().find('.'+options.trLoadingClass+'.row-'+tr_id).remove();
      attr.after(options.renderLoading(tr_id));
      attr.find('td.td-expand').removeClass('minus').addClass('plus');
      $.ajax({
        url: options.url+"?"+options.searchUrl,
        type: 'GET',
        cache: false,
        dataType: 'json',
        data : {
          child     : child,
          parent_id : parent_id
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
    $(options.tableAttr).on('click','.pagination>li>a', function(event) {
      event.preventDefault();
      /* Act on the event */
      if(!$(this).hasClass('disabled')){
        var page = $(this).data('page');
        $(options.tableAttr).find('.form-search').find('.page').val(page);
        options.searchUrl = $(options.tableAttr).find('.form-search').serialize();
        window.history.pushState("", "", "?"+options.searchUrl);
        options.tableAttr.prepend(options.loadingHtml);
        options.ajaxPro();
      }
    });
    $(options.tableAttr).on('submit','.form-search', function(event) {
      event.preventDefault();
      /* Act on the event */
        $(this).find('.page').val('1');
        $(this).find('.limit').val(options.limit);
        options.searchUrl = $(this).serialize();
        options.tableAttr.prepend(options.loadingHtml);
        window.history.pushState({}, "", "?"+$(this).serialize());
        options.ajaxPro();
    });
    $(options.tableAttr).on('click','.reset', function(event) {
      // event.preventDefault();
      // $(this).find('input,select').val('');
      /* Act on the event */
        $(options.tableAttr).find('.form-search').find('input:enabled,select:enabled').val('');
        window.history.pushState({}, "", "?");
        $(options.tableAttr).find('.form-search').find('.page').val('1');
        $(options.tableAttr).find('.form-search').find('.limit').val(options.limit);
        options.tableAttr.prepend(options.loadingHtml);
        options.searchUrl = "page=1&limit="+options.limit;
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
    $(options.tableAttr).find('.form-search').trigger('submit');
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
  var options = {
    url : '{!!route('doc',['status'=>$doc_status])!!}',
    with_number : true,
    data : [
      { name : 'title' , title  : 'Judul - No Kontrak',orderable:true},
      { name : 'sup_name' , title  : 'Vendor',orderable:true},
      { name : 'doc_enddate' , title  : 'Tanggal Akhir',orderable:true},
      // { name : 'status' , title  : 'Status',orderable:true},
      { name : 'jenis.type.title' , title  : 'Type',orderable:true},
      { name : 'link' , title  : 'Action'},
    ],
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
</script>
<script>
var user_role = '{{$user->role_name}}';
if(user_role!='monitor'){
  $('#divisi').prop('disabled', 'disabled');
}
$(document).on('change', '#divisi', function(event) {
  event.preventDefault();
  /* Act on the event */
  var divisi = this.value;
  //if(unit!==""){
  $('#unit_bisnis').find('option').not('option[value=""]').remove();
  var t_awal = $('#unit_bisnis').find('option[value=""]').text();
  $('#unit_bisnis').find('option[value=""]').text('Please wait.....');
  $('#unit_kerja').find('option').not('option[value=""]').remove();
    $.ajax({
      url: '{!!route('doc.get-unit-bisnis')!!}',
      type: 'GET',
      cache: false,
      dataType: 'json',
      data: {divisi: encodeURIComponent(divisi)}
    })
    .done(function(data) {
      if(data.length>0){
        $.each(data,function(index, el) {
          $('#unit_bisnis').append('<option value="'+this.id+'">'+this.title+'</option>');
        });
        $('#unit_bisnis').find('option[value=""]').text('Pilih Unit Bisnis');
      }
      else{
        $('#unit_bisnis').find('option[value=""]').text('Tidak ada data');
      }
    });
  //}
});
$(document).on('change', '#unit_bisnis', function(event) {
  event.preventDefault();
  /* Act on the event */
  var unit_bisnis = this.value;
  //if(unit!==""){
  $('#unit_kerja').find('option').not('option[value=""]').remove();
  var t_awal = $('#unit_kerja').find('option[value=""]').text();
  $('#unit_kerja').find('option[value=""]').text('Please wait.....');
    $.ajax({
      url: '{!!route('doc.get-unit-kerja')!!}',
      type: 'GET',
      cache: false,
      dataType: 'json',
      data: {unit_bisnis: encodeURIComponent(unit_bisnis)}
    })
    .done(function(data) {
      if(data.length>0){
        $.each(data,function(index, el) {
          $('#unit_kerja').append('<option value="'+this.id+'">'+this.title+'</option>');
        });
        $('#unit_kerja').find('option[value=""]').text('Pilih Unit Kerja');
      }
      else{
        $('#unit_kerja').find('option[value=""]').text('Tidak ada data');
      }
    });
  //}
});
$(function(e){
    var unit_bisnis = '{{$form['unit_bisnis']}}';
    var unit_kerja = '{{$form['unit_kerja']}}';
    if(unit_bisnis!="" && $('#unit_bisnis').val()!="" && unit_kerja==""){
      $('#unit_bisnis').change();
    }
    if($('#divisi').val()!=="" && unit_bisnis==""){
      $('#unit_bisnis').find('option').not('option[value=""]').remove();
      if(user_role!='monitor'){
        $('#divisi').change();
      }
    }
});
</script>
@endpush
