<div class="col-md-6">
  <img src="{{asset('images/telkom_indonesia.png')}}">
</div>
<br><br>
<div class="col-md-12">
  Kepada Yth.
  <br>Pimpinan {{$nama_perusahaan}}
  <br>up. {{ $sendTo }}
<br>
<br>
<p>
  Terima kasih untuk telah mendaftarkan perusahaan yang Bapak/Ibu pimpin sebagai Mitra PT Telkom Indonesia.<br>

  <br>Untuk dapat mengakses halaman Mitra dan melengkapi data perusahaan yang dibutuhkan sebagai persyaratan menjadi Mitra PT Telkom Indonesia, gunakan tautan berikut: <a href="{{url('/login')}}">Login</a> dengan
  Username <b> {{ $mail_message }} </b> dan password sesuai dengan informasi yang diinput saat pendaftaran.<br><br>

  Terima kasih atas perhatian dan kerjasamanya.<br><br>

  Hormat kami,<br>
  PT Telkom Indonesia
</p>
</div>
