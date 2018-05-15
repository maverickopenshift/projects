<!-- modal-preview-pdf -->
<div class="modal fade" id="ModalPDF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel"></h4> 
      </div>
      <div class="modal-body">
        <div id="viewerContainer" style="margin-bottom: 30px;">
          <div id="viewer" class="pdfViewer"></div>
        </div>
        {{-- <div style="overflow: auto;" style="text-align: center;" id="holder">   
        </div> --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
  <!-- Javascript Preview PDF -->
  <script src="{{asset('js/pdfjs-dist/build/pdf.min.js')}}"></script>
  <script src="{{asset('js/pdfjs-dist/web/pdf_viewer.js')}}"></script>
  <script src="{{asset('js/pdf_view.js')}}"></script>

  <script type="text/javascript">

    $('#ModalPDF').on('show.bs.modal', function (e) {
      var url = $(e.relatedTarget).data('load-url');
      var checkbox = $(e.relatedTarget).parent().find('.disclaimer');
      $(this).find('.modal-body').find('.form-horizontal.well.well-sm').remove();
      $(this).find('.modal-body').append(template_disclaimer_modal());
      if(checkbox.is(':checked')){
        $(this).find('.modal-body').find('.disclaimer_modal').prop('checked', true);
      }
      else{
        $(this).find('.modal-body').find('.disclaimer_modal').prop('checked', false);
      }
      $(this).find('#viewer').html('');
      pdf_view(url);  
      $('.disclaimer_modal').on('click', function(event) {
        if($(this).is(':checked')) {
          checkbox.prop('checked',true);
        }else{
          checkbox.prop('checked',false);
        }
      });
    });
    function template_disclaimer_modal(){
      return '<div class="form-horizontal well well-sm">\
        <div class="form-group" style="margin-bottom:0px">\
          <label class="col-sm-2 control-label">Disclaimer</label>\
          <div class="col-sm-10 text-me">\
            <div class="checkbox" style="padding-top:0px;">\
              <label>\
                <input type="checkbox" class="disclaimer_modal" autocomplete="off"> Saya sudah membaca seluruh isi dan dokumen terlampir. Semua sudah sesuai\
              </label>\
            </div>\
          </div>\
        </div>\
      </div>';
    }
  </script>
@endpush