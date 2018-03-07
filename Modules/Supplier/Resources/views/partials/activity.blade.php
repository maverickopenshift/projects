<!-- Construct the box with style you want. Here we are using box-danger -->
  <!-- Then add the class direct-chat and choose the direct-chat-* contexual class -->
  <!-- The contextual class should match the box, so we are using direct-chat-danger -->
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary direct-chat direct-chat-primary">
      <div class="box-header with-border">
        <i class="fa fa-comments-o"></i>
        <h3 class="box-title">Log Activity</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body relative">
        <div class="loading-ao"></div>
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages">
        </div><!--/.direct-chat-messages-->
      </div><!-- /.box-body -->
      <div class="box-footer relative komentar formerror formerror-komentar" style="Display:none">
          <div class="loading-ao"></div>
          <div id="alertBS"></div>
          <textarea class="form-control comment" rows="4" placeholder="Masukan Komentar" name="komentar">{{ old('komentar') }}</textarea>
          <div class="error error-komentar"></div>
      </div><!-- /.box-footer-->
    </div><!--/.direct-chat -->
  </div>
</div>

  @push('scripts')
  <script>
  var id = $('#id_supplier').val();
  var user_un = '{!!Auth::user()->username!!}';
  var user_nm = '{!!Auth::user()->name!!}';
  $(function() {
    loadComments();
  });

  function loadComments(){
    var ctn = $('.direct-chat-messages');
    var loading = ctn.parent().find('.loading-ao');
    ctn.html('');
    loading.show();
    ctn.find('.alert').remove();
    $.ajax({
      url: '{!!route('sup.comments')!!}',
      type: 'GET',
      dataType: 'json',
      data: {id: id}
    })
    .done(function(data) {
      if(data.length>0){
        $.each(data.data,function(index, el) {
          ctn.append(template_comment(this));
        });
      }
      else{
        ctn.append('<div class="alert alert-info text-center" role="alert">Tidak ada Log Activity</div>');
      }
      loading.hide();
    });

  }
  function template_comment(data){
    var user_dt = data.user.username;
      if(data.activity == "Returned"){
        var acvtivity = '<span class="label label-danger">'+data.activity+'</span>';
      }else{
        var acvtivity = '<span class="label label-success">'+data.activity+'</span>';
      }
    var oe = (user_un==user_dt)?'':'other';
    var btn = (user_un==user_dt || is_admin())?btn:'';
    var full_n = data.user.name+'('+data.user.username+')';
    var temp = '<div class="direct-chat-msg '+oe+'">\
                <div class="direct-chat-info clearfix">\
                  <div class="pull-left">\
                    <span class="fa-stack">\
                      <i class="fa fa-square fa-stack-2x"></i>\
                      <i class="fa fa-user fa-stack-1x fa-inverse"></i>\
                    </span>\
                    <span class="direct-chat-name">'+full_n+'</span>\
                  </div>\
                  <div class="pull-right">\
                    <span class="direct-chat-timestamp">\
                      '+acvtivity+' at \
                      '+$.format.date(data.date+".546", "dd/MM/yyyy HH:mm")+'\
                    </span>\
                  </div>\
                </div>\
                <!--<img class="direct-chat-img" src="{{asset('/images/user_default.png')}}" alt="'+full_n+'">-->\
                <div class="direct-chat-text">\
                  '+data.komentar+'\
                </div>\
              </div>';
    return temp;
  }

  </script>
  @endpush
