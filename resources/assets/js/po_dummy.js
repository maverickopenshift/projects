function render_po(po){
  var error_po = $('.error-po');
  var table = $('#potables');
  var parentPO = $('#parentPO');
  var loading = table.find('.loading-tr');
  loading.show();
  var tr_count = table.find('tbody>tr').not('tbody>tr.loading-tr');
  table.parent().hide();
    $.ajax({
      url: routes.getPO,
      type: 'GET',
      dataType: 'json',
      data: {po: po}
    })
    .done(function(response) {
      if(response.status){
        if(response.length==0){
          error_po.html('No.PO tidak ditemukan!');
        }
        else{
          var data = response.data;
          loading.hide();
          table.parent().show();
          var tr;
          $.each(data,function(index, el) {
            var po_data = {
              no         : (index+1),
              kode_item  : this.kode_item,
              item       : this.item,
              qty        : formatRupiah(this.qty),
              satuan     : this.satuan,
              mtu        : this.mtu,
              harga      : formatRupiah(this.harga),
              harga_total: formatRupiah(this.harga_total),
              keterangan : this.keterangan,
            }
            var tr = templatePO(po_data);
            table.find('tbody').append(tr);
          });
          var td = ParentPO();
          parentPO.find('tbody').append(td);
          error_po.html('');
        }
      }
    });
}
function templatePO(data) {
  return '<tr>\
              <td>'+data.no+'</th>\
              <td>'+data.kode_item+'</th>\
              <td>'+data.item+'</th>\
              <td>'+data.qty+'</th>\
              <td>'+data.satuan+'</th>\
              <td>'+data.mtu+'</th>\
              <td>'+data.harga_total+'</th>\
              <td>-</th>\
              <td>-</th>\
              <td>'+data.keterangan+'</th>\
          </tr>';
}

function ParentPO() {
  var nopo = $('.no_po').val();
  return '<tr>\
            <td width="150">No PO </td>\
            <td width="10">:</td>\
            <td>'+nopo+'<input type="hidden" name="po_no" value="'+nopo+'"></td>\
          </tr>\
          <tr>\
            <td>Tanggal PO</td>\
            <td> : </td>\
            <td>27 Agustus 2017<input type="hidden" name="po_date" value="2017-08-27"></td>\
          </tr>\
          <tr>\
            <td>Nama Vendor</td>\
            <td> : </td>\
            <td>PT Jaya Makmur Sentosa<input type="hidden" name="po_vendor" value="PT Jaya Makmur Sentosa"></td>\
          </tr>\
          <tr>\
            <td>Nama Pembuat/nik</td>\
            <td> : </td>\
            <td>SUMARNI/123456<input type="hidden" name="po_pembuat" value="SUMARNI"><input type="hidden" name="po_nik" value="123456"></td>\
          </tr>\
          <tr>\
            <td>Nama Approval PO</td>\
            <td> : </td>\
            <td>Purwiro<input type="hidden" name="po_approval" value="Purwiro"></td>\
          </tr>\
          <tr>\
            <td>Nama Penandatangan PO</td>\
            <td> : </td>\
            <td>Januar <input type="hidden" name="po_penandatangan" value="Januar"></td>\
          </tr>';
}