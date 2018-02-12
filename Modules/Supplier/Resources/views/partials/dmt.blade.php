<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
      .heading{
        color:red;
        right: 60px;
      }
    </style>
  </head>
  <body>
    <!-- <img src="{{asset('images/logo_new.png')}}" width="100px" align="right" alt="PT Telekomunikasi Indonesia, Tbk."><br><br> -->
<p align="right">
    <img src="https://upload.wikimedia.org/wikipedia/id/thumb/c/c4/Telkom_Indonesia_2013.svg/1200px-Telkom_Indonesia_2013.svg.png" width="100px">
</p><br>
  <center>
    <p>
      <strong style="font-size:150%;"><u> DAFTAR MITRA TELKOM </u></strong><br>
      <small>No: {{$kode}}</small>
    </p>
  </center>

  <br><br>
  <p>
    Menerangkan bahwa,<br>
    <table>
      <tr>
        <td>Pimpinan Perusahaan</td>
        <td> : </td>
        <td> {{$pimpinan or '-'}} </td>
      </tr>
      <tr>
        <td>Nama Perusahaan</td>
        <td> : </td>
        <td> {{$nama_perusahaan or '-'}} </td>
      </tr>
      <tr>
        <td>Alamat Perusahaan</td>
        <td> : </td>
        <td> {{$alamat or '-'}} </td>
      </tr>
      <tr>
        <td>Kota Perusahaan</td>
        <td> : </td>
        <td> {{$kota or '-'}} </td>
      </tr>
      <tr>
        <td>Klasifikasi Perusahaan</td>
        <td> : </td>
        <td>Kode Klasifikasi - Nama Klasifikasi</td>
      </tr>
      @foreach($klasifikasi_kode as $key => $val)
      <tr>
        <td></td>
        <td></td>
        <td><li> {{$klasifikasi_kode[$key] or '-'}} - {{$klasifikasi_text[$key] or '-'}} </li></td>
      </tr>
      @endforeach
    </table><br><br>

  Telah tercatat dalam Daftar Mitra PT Telekomunikasi Indonesia, Tbk.<br>
  Daftar Mitra ini berlaku 2 (dua) tahun sejak tanggal diterbitkan, atau sejak tanggal selesainya pekerjaan terakhir di Telkom.<br><br>

  Jakarta, {{$date}}<br>
  <!-- <br>
  <br>
  <br>
  <br> -->
  <p style="margin-top: 8%;"><u>SENO AJI WAHYONO</u><br>
    AVP SUPPLY ANALYSIS</p>
  </p>

  <p  style="margin-top: 25%; margin-bottom: -10%;">Disclaimer: Tanpa ditanda-tangani dokumen ini sah di lingkungan PT. Telekomunikasi Indonesia, tbk.</p>

</body>
</html>
