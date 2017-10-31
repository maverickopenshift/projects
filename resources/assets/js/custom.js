jQuery.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
    if(oSettings.oFeatures.bServerSide === false){
        var before = oSettings._iDisplayStart;

        oSettings.oApi._fnReDraw(oSettings);

        // iDisplayStart has been reset to zero - so lets change it back
        oSettings._iDisplayStart = before;
        oSettings.oApi._fnCalculateEnd(oSettings);
    }

    // draw the 'current' page
    oSettings.oApi._fnDraw(oSettings);
};
var datepicker_ops={
    format: 'yyyy-mm-dd',
    autoclose:true,
    todayHighlight:true
};
function alertBS(msg,type) {
    var alertHtml = '<div class="alert alert-'+type+' alert-dismissible" role="alert">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span></button>'+
        msg+
    '</div>';
    $('#alertBS').html(alertHtml);
    $("#alertBS").fadeTo(2000, 500).slideUp(500, function(){
        $("#alertBS").slideUp(500);
    });

}
function alertBS2(msg,type) {
    var alertHtml = '<div class="alert alert-'+type+' alert-dismissible" role="alert">'+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span></button>'+
        msg+
    '</div>';
    $('.alertBS').html(alertHtml);
}
function confimME(msg,callback) {
    var txt;
    var r = confirm(msg);
    if (r == true) {
        return callback;
    }
}
$(function(e){
  $('.date').datepicker(datepicker_ops);
  $('.date').on('changeDate', function() {
    //  $(this).hide();
  });
  $('.tagsinput').tagsinput({
    trimValue: true,
    confirmKeys: [44],
    splitOn: ','
  });
  $('form').on('reset',function(){
    $(this).find('.tagsinput').tagsinput('removeAll');
    //$('.date').val("").datepicker("update");
    //$(this).find(".date").datepicker("clearDates");
    //$(this).find(".date").datepicker('destroy');
    //$(this).find(".date").datepicker(datepicker_ops);
  });
  $(document).on('click', '.click-upload', function(event) {
    /* Act on the event */
    var $this = $(this);
    var $file = $this.parent().parent().find('input[type="file"]');
    var $file_txt = $this.parent().parent().find('input[type="text"]');
    $file.click();
    $file.change(function(){
      $file_txt.val($(this).val());
    }); 
  });
});
