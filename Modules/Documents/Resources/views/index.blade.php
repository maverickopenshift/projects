@extends('layouts.app')

@section('content')
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Visitors Report</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
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
          <input class="form-controsl" name="oke" />
      </div>
      {{-- <table class="table table-condensed table-striped table-ao">
          <thead>
          <tr>
              <th>No.</th>
              <th>No Kontrak</th>
              <th>Judul</th>
              <th>Type</th>
          </tr>
          </thead>
          <tbody>
            <tr class="loading-tr">
              <td colspan="10" class="text-center"><img src="{{asset('/images/loader.gif')}}" title="please wait..."/></td>
            </tr>
          </tbody>
      </table> --}}
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
        render += '<td>'+((data[this.name]==null)?'-':data[this.name])+'</td>';
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
      { name : 'doc_type' , title  : 'Type',orderable:true},
    ],
    page : 1,
    limit : 25,
  };
  $('.table-kontrak').tableLaravel(options);
});
</script>
@endpush
