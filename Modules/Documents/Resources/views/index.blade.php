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
      </div>
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th style="width:50px;">No.</th>
            <th style="width:350px;">Judul</th>
            <th style="width:300px;">No Kontrak</th>
            <th style="width:300px;">Vendor</th>
            <th style="width:100px;">Type</th>
            <th style="width:90px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>PENGADAAN DAN PEMASANGAN KABEL FIBER OPTIK</td>
            <td>K.TEL.00001/HK.810/L002K/2017</td>
            <td>CV.Maju Mundur</td>
            <td>Turnkey</td>
            <td>
              <a class="btn btn-xs btn-primary" href="http://consys.in2digital.net:81/documents/view/turnkey/11">Lihat</a>
            </td>
          </tr>
          <tr>
            <td colspan="6" class="no-padding">
                <table class="table table-condensed table-striped" style="margin-bottom:0;">
                  <thead>
                    <tr>
                      <td style="width:50px;"></td>
                      <th style="width:260px;">Judul</th>
                      <th>No</th>
                      <th>Vendor</th>
                      <th>Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td>- SP #1</td>
                      <td>K.TEL.00003/HK.810/L002K/2017</td>
                      <td>CV.Maju Mundur</td>
                      <td>SP</td>
                      <td><a class="btn btn-xs btn-primary" href="http://consys.in2digital.net:81/documents/view/turnkey/11">Lihat</a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>- SP #2</td>
                      <td>K.TEL.00004/HK.810/L002K/2017</td>
                      <td>CV.Maju Mundur</td>
                      <td>SP</td>
                      <td><a class="btn btn-xs btn-primary" href="http://consys.in2digital.net:81/documents/view/turnkey/11">Lihat</a></td>
                    </tr>
                    <tr>
                      <td colspan="6" class="no-padding">
                        <table class="table table-condensed table-striped" style="margin-bottom:0;">
                          <thead>
                            <tr>
                              <td style="width:80px;"></td>
                              <th style="width:250px;" >Judul</th>
                              <th>No</th>
                              <th>Vendor</th>
                              <th>Type</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td></td>
                              <td>- Amandemen #1</td>
                              <td>K.TEL.00003/HK.810/L002K/2017</td>
                              <td>CV.Maju Mundur</td>
                              <td>Amandemen SP</td>
                              <td><a class="btn btn-xs btn-primary" href="http://consys.in2digital.net:81/documents/view/turnkey/11">Lihat</a></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>- Amandemen #1</td>
                      <td>K.TEL.00003/HK.810/L002K/2017</td>
                      <td>CV.Maju Mundur</td>
                      <td>Amandemen Kontrak</td>
                      <td><a class="btn btn-xs btn-primary" href="http://consys.in2digital.net:81/documents/view/turnkey/11">Lihat</a></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>- Amandemen #2</td>
                      <td>K.TEL.00004/HK.810/L002K/2017</td>
                      <td>CV.Maju Mundur</td>
                      <td>Amandemen Kontrak</td>
                      <td><a class="btn btn-xs btn-primary" href="http://consys.in2digital.net:81/documents/view/turnkey/11">Lihat</a></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>PENGADAAN DAN PEMASANGAN JEMBATAN</td>
              <td>K.TEL.00002/HK.810/L002K/2017</td>
              <td>PT.Muncul Jaya</td>
              <td>KHS</td>
              <td>
                <a class="btn btn-xs btn-primary" href="http://consys.in2digital.net:81/documents/view/khs/10">Lihat</a>
              </td>
            </tr>
          </tbody>
        </table>
    </div>
<!-- /.box-body -->
</div>
@endsection
@push('scripts')
<script>
$.fn.tableLaravel = function(options) {
    options.tableAttr = this;
    options.tableClass = 'table table-condensed table-striped';
    options.tableAttr.css({position:'relative'});
    options.withNumber = true,
    options.emptyMessage = 'No data available!';
    options.cssLoading='background-color: rgba(255,255,255,0.5);position: absolute;width: 100%;height: 100%;background-image: url(images/loader.gif);background-position: center center;background-repeat: no-repeat;z-index:1000;';
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
    options.tableHTML=$('<table/>', {class: options.tableClass+' tableLaravel'});
    options.tableHTML.append(options.renderHeader()).append('<tbody></tbody>');
    options.tableAttr.append(options.tableHTML);
    options.tableAttr.prepend(options.loadingHtml);
    options.renderData = function(data,no){
      var render = '<tr>';
      if(options.withNumber){
          render += '<td>'+(no+1)+'</td>';
      } 
      $.each(options.data,function(index, el) {
        if(this.name!==false && this.html===undefined){
          var rend_dt = options.splitName(data,this.name);
          render += '<td>'+((rend_dt==null || rend_dt===undefined)?'-':rend_dt)+'</td>';
        }
        else{
          if(this.name===false && this.html!==undefined){
            render += '<td>'+options.parseHTML(this.html,data)+'</td>';
          }
          else{
            render += '<td></td>';
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
    options.pagination = function(data){
      var render_pg='';
      if(data.last_page>1){
        render_pg += '<ul class="pagination">';
          if(data.current_page != 1 && data.last_page >=5){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page=1&limit='+options.limit+'>&laquo;</a>';
            render_pg += '</li>';
          }
          else{
              render_pg += '<li class="disabled">';
              render_pg += '<a href="#">&laquo;</a>';
              render_pg += '</li>';
          }
          if(data.current_page != 1){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page='+(data.current_page-1)+'&limit='+options.limit+'>Prev</a>';
            render_pg += '</li>';
          }          
          else{
              render_pg += '<li class="disabled">';
              render_pg += '<a href="#">Prev</a>';
              render_pg += '</li>';
          }
          for (var i = Math.max((data.current_page-2), 1); i <= Math.min(Math.max((data.current_page-2), 1)+4,data.last_page); i++) {
            render_pg += '<li class="'+((data.current_page==i)?' active':' ')+'">';
            render_pg += '<a class="'+((data.current_page==i)?'disabled':' ')+'" href='+options.url+'?page='+(i)+'&limit='+options.limit+'>'+i+'</a>';
            render_pg += '</li>';
          }
          if(data.current_page != data.last_page){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page='+(data.current_page+1)+'&limit='+options.limit+'>Next</a>';
            render_pg += '</li>';
          }
          else{
            render_pg += '<li class="disabled">';
            render_pg += '<a href="#">Next</a>';
            render_pg += '</li>';
          }
          if(data.current_page != data.last_page && data.last_page>=5){
            render_pg += '<li>';
            render_pg += '<a href='+options.url+'?page='+(data.last_page)+'&limit='+options.limit+'>&raquo;</a>';
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
    options.ajaxPro = function(){
      $.ajax({
        url: options.url,
        type: 'GET',
        dataType: 'json',
        data : {
          page  : options.page,
          limit : options.limit
        }
      })
      .done(function(data) {
        if(data.data.length>0){
          options.tableAttr.find('.empty-data').remove();
          var render;
          $.each(data.data,function(index, el) {
            render += options.renderData(this,index);
          }); 
          options.tableAttr.find('tbody').html('');
          options.tableAttr.find('tbody').append(render);
          options.tableAttr.find('.pagination').remove();
          options.tableAttr.append(options.pagination(data));
          console.log(options.count_td());
        }
        else{
          options.tableAttr.find('tbody').append(options.renderEmpty);
          console.log('empty');
        }
        options.tableAttr.find('.'+options.loading).remove();
      });
    }
    options.ajaxPro();
    $(document).on('click','.pagination>li>a', function(event) {
      event.preventDefault();
      /* Act on the event */
      if(!$(this).hasClass('disabled')){
        var urls = $(this).attr('href');
        console.log($(this));
        options.page = options.getParams('page',options.page,urls);
        options.limit = options.getParams('limit',options.limit,urls);
        window.history.pushState("", "", urls);
        options.tableAttr.prepend(options.loadingHtml);
        options.ajaxPro();
      }
    });
    return this;
}
$(function () {
  var options = {
    url : '{!!route('doc')!!}',
    with_number : true,
    data : [
      { name : 'doc_no' , title : 'No Kontrak',orderable:true},
      { name : 'doc_title' , title  : 'Judul',orderable:true},
      { name : 'supplier.nm_vendor' , title  : 'Vendor',orderable:true},
      { name : 'jenis.type.title' , title  : 'Type',orderable:true},
      { name : 'link' , title  : 'Action'},
    ],
    page : 1,
    limit : 25,
  };
  $('.table-kontrak').tableLaravel(options);
});
</script>
@endpush
