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
/* Create an array with the values of all the input boxes in a column */
$.fn.dataTable.ext.order['dom-text'] = function  ( settings, col )
{
    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
        return $('input', td).val();
    } );
}
 
/* Create an array with the values of all the input boxes in a column, parsed as numbers */
$.fn.dataTable.ext.order['dom-text-numeric'] = function  ( settings, col )
{
    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
        return $('input', td).val() * 1;
    } );
}
 
/* Create an array with the values of all the select options in a column */
$.fn.dataTable.ext.order['dom-select'] = function  ( settings, col )
{
    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
        return $('select', td).val();
    } );
}
 
/* Create an array with the values of all the checkboxes in a column */
$.fn.dataTable.ext.order['dom-checkbox'] = function  ( settings, col )
{
    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
        return $('input', td).prop('checked') ? '1' : '0';
    } );
}
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
function toRP(bilangan){
  var	number_string = bilangan.toString(),
  	split	= number_string.split(','),
  	sisa 	= split[0].length % 3,
  	rupiah 	= split[0].substr(0, sisa),
  	ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
  		
  if (ribuan) {
  	separator = sisa ? '.' : '';
  	rupiah += separator + ribuan.join('.');
  }
  rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
  return ribuan;
}
$(document).on('keyup', '.input-rupiah', function(event) {
  event.preventDefault();
  /* Act on the event */
  var rupiah = formatRupiah($(this).val());
  $(this).val(rupiah);
});
function formatRupiah(angka, prefix)
{
  var angka = angka.toString();
	var number_string = angka.replace(/[^,\d]/g, ''),
		split	= number_string.split(','),
		sisa 	= split[0].length % 3,
		rupiah 	= split[0].substr(0, sisa),
		ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
		
	if (ribuan) {
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
	
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
function convertNumber(number) {
  var number = number.toString();
  var split = number.split('.');
  if(split.length==2){
    if(split[1]!=""){
      var decimal = split[1];
      decimal = decimal.substr(0,3);
      if(decimal!="000"){
        number = split[0]+','+decimal.substr(0,3);
      }
    }
  }
  else{
    number = split[0]
  }
  return number;
  //console.log('harga_total => '+formatRupiah(harga_total));
}
function backNominal(angka){
  var angka = angka.toString();
  var clean = angka.replace(/[^,\d]/g, ''),
		split	= clean.split(','),
		sisa 	= split[0].length % 3,
		rupiah 	= split[0].substr(0, sisa),
		ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
    // console.log('split => '+JSON.stringify(split));
    // console.log('sisa => '+sisa);
    // console.log('rupiah => '+rupiah);
    // console.log('ribuan => '+ribuan);
    if(split.length==2){
      if(split[1]!=""){
        return parseFloat(split[0]+'.'+split[1]);
      }
    }
  return parseInt(split[0]);
}