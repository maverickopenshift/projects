<!-- Construct the box with style you want. Here we are using box-danger -->
  <!-- Then add the class direct-chat and choose the direct-chat-* contexual class -->
  <!-- The contextual class should match the box, so we are using direct-chat-danger -->
  <div class="box box-primary direct-chat direct-chat-primary">
    <div class="box-header with-border">
      <i class="fa fa-comments-o"></i>
      <h3 class="box-title">Komentar</h3>
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
    <div class="box-footer relative">
      <form method="post" id="form-comment" action="#" data-action="{{route('doc.comment.add',['id'=>$id])}}">
        <div class="loading-ao"></div>
        <div id="alertBS"></div>
        {{ csrf_field() }}
        <textarea class="form-control comment" rows="4" placeholder="Masukan Komentar" name="content"></textarea>
        <div class="text-center">
          <button type="submit" class="btn btn-success btn-flat top10 btn-comment">Submit</button>
        </div>
      </form>
    </div><!-- /.box-footer-->
  </div><!--/.direct-chat -->
  @push('scripts')
  <script>
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
      url: '{!!route('doc.comments')!!}',
      type: 'GET',
      dataType: 'json',
      data: {id: {!!$id!!}}
    })
    .done(function(data) {
      if(data.length>0){
        $.each(data.data,function(index, el) {
          ctn.append(template_comment(this));
        });
      }
      else{
        ctn.append('<div class="alert alert-info text-center" role="alert">Tidak ada komentar</div>');
      }
      loading.hide();
    });
    
  }
  function template_comment(data){
    var user_dt = data.user.username;
    var btn = '<!--<a href="#">\
                <span class="fa-stack">\
                  <i class="fa fa-square fa-stack-2x text-success"></i>\
                  <i class="fa fa-edit fa-stack-1x fa-inverse"></i>\
                </span>\
              </a>-->\
              <a href="#" class="btn-delete-comment" data-id="'+data.id+'">\
                <span class="fa-stack">\
                  <i class="fa fa-square fa-stack-2x text-danger"></i>\
                  <i class="fa fa-trash fa-stack-1x fa-inverse"></i>\
                </span>\
              </a>';
    var lable = (data.status==1)?' <span class="label label-danger">returned</span>':'';          
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
                    '+lable+'\
                  </div>\
                  <div class="pull-right">\
                    '+btn+'\
                    <span class="direct-chat-timestamp">\
                      <span class="fa-stack">\
                        <i class="fa fa-square fa-stack-2x"></i>\
                        <i class="fa fa-calendar fa-stack-1x fa-inverse"></i>\
                      </span>\
                      '+$.format.date(data.created_at+".546", "dd/MM/yyyy HH:mm")+'\
                    </span>\
                  </div>\
                </div>\
                <!--<img class="direct-chat-img" src="{{asset('/images/user_default.png')}}" alt="'+full_n+'">-->\
                <div class="direct-chat-text">\
                  '+data.content+'\
                </div>\
              </div>';
    return temp;
  }
  $(document).on('submit', '#form-comment', function(event) {
    event.preventDefault();
    /* Act on the event */
    var form = $(this);
    var d_text = form.find('textarea.comment');
    if(d_text.val()=="") {return false;}
    var loading = form.find('.loading-ao');
    loading.show();
    $.ajax({
        url: form.data('action'),
        type: 'post',
        data: form.serialize(), // Remember that you need to have your csrf token included
        dataType: 'json',
        success: function( _response ){
            // Handle your response..
            console.log(_response)
            if(_response.errors){
                if(_response.errors.content){
                  alertBS(response.errors.content,'danger')
                }
            }
            else{
                alertBS('Komentar berhasil ditambahkan','success');
                $('.direct-chat-messages').find('.alert').remove();
                $('.direct-chat-messages').append(template_comment(_response));
                d_text.val('');
            }
            loading.hide();
        },
        error: function( _response ){
            alertBS('Something wrong, please try again','danger');
            d_text.val('');
            loading.hide();
        }
    });
  });
  $(document).on('click', '.btn-delete-comment', function(event) {
    event.preventDefault();
    var btn = $(this);
    var btn_parent = btn.parent().parent().parent();
    swal({
      title:'Anda yakin ingin menghapus komentar?',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak',
      showLoaderOnConfirm: true,
      preConfirm: function (text) {
         return new Promise(function (resolve, reject) {
           btn_parent.parent().parent().find('.loading-ao').show();
           $.ajaxSetup({
             headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           $.ajax({
             url: '{!!route('doc.comment.delete')!!}',
             type: 'DELETE',
             dataType: 'json',
             data: {id: btn.data('id')}
           })
           .done(function(data) {
             resolve();
           });

         })
      },
    }).then(function (text) {
      btn_parent.parent().parent().find('.loading-ao').hide();
      btn_parent.remove();
    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {

      }
    })
  });
  </script>
  @endpush