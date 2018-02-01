<div class="col-md-6">
  <img src="{{asset('images/logo_telkom.png')}}" width="100px">
</div>
<br><br>
<div class="col-md-12">
  Kepada Yth.
  <br>Pimpinan {{$nama_perusahaan}}
  <br>up. {{ $sendTo }}
<br>
<br>
<p>
  Password: {{ $random_pwd }} <br>
  <br>Untuk dapat mengakses halaman Mitra dan melengkapi data perusahaan yang dibutuhkan sebagai persyaratan menjadi Mitra PT Telkom Indonesia, gunakan tautan berikut: <a href="{{url('/login')}}">Login</a>

  Terima kasih atas perhatian dan kerjasamanya.<br><br>

  Hormat kami,<br>
  PT Telkom Indonesia
</p>
</div>
