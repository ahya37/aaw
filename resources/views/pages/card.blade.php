<html>
  <head>
    <title>Card</title>
  </head>

  <style>
    body {
      position: relative;
      width: 1000px;
      height: 1000px;
      margin-left: -370px;
      background-color: #ffffff;

    }
    .layout-left {
      position: absolute;
      width: 372px;
      height: 199.8px;
      left: 348px;
      top: 366px;
      /* margin-left: 366px; */

      background: #ffffff;
      border: 1px solid #000000;
    }

    .layout-right {
      position: absolute;
      width: 372px;
      height: 199.8px;
      left: 720px;
      top: 366px;
      background: #ffffff;
      border: 1px solid #000000;
    }
    .title {
      /* position: absolute; */
      width: 372px;
      height: 16px;
      margin-left: 10px;
      margin-right: 201px;
      margin-top: 9px;

      font-family: sans-serif;
      font-style: normal;
      font-weight: 900;
      font-size: 14px;
      line-height: 16px;

      color: #000000;
    }
    .logo {
      position: absolute;
      width: 80px;
      height: 52px;
      margin-left: 281px;
      margin-top: -15px;
      margin-bottom: 101.9px;
    }
    .img {
      /* position: absolute; */
      width: 50px;
      height: 60px;
      margin-top: 10px;
      margin-left: 10px;
      border-radius: 8px;
    }
    .name {
      position: absolute;
      width: 100%;
      height: 14px;
      margin-top: 25px;
      margin-left: 8px;
      font-family: sans-serif;
      font-style: normal;
      font-weight: bold;
      font-size: 12px;
      line-height: 12px;
      color: #002efe;

      
    }
    .base {
      position: absolute;
      width: 100%;
      height: 16px;
      margin-top: 40px;
      margin-left: 3px;

      font-family: sans-serif;
      font-style: normal;
      font-weight: bold;
      font-size: 10px;
      line-height: 9px;

      color: #f90909;
    }
    .code {
      position: absolute;
     width: 100%;
      height: 14px;
      margin-top: 53px;
      /* margin-left: 2px; */

      font-family: sans-serif;
      font-style: normal;
      font-weight: bold;
      font-size: 10px;
      line-height: 12px;

      color: #000000;
    }
    .address {
      position: absolute;
     width: 100%;
      height: 14px;
      left: 358px;
      top: 480px;

      font-family: sans-serif;
      font-style: normal;
      font-weight: normal;
      font-size: 10px;
      line-height: 12px;

      color: #000000;
    }
    .regency {
      position: absolute;
      width: 100%;
      height: 14px;
      left: 358px;
      top: 494px;

      font-family: sans-serif;
      font-style: normal;
      font-weight: normal;
      font-size: 10px;
      line-height: 12px;

      color: #000000;
    }
    .province {
      position: absolute;
      width: 100%;
      height: 14px;
      left: 358px;
      top: 507px;

      font-family: sans-serif;
      font-style: normal;
      font-weight: bold;
      font-size: 10px;
      line-height: 12px;
    }
    .flat1 {
      position: absolute;
      width: 372px;
      height: 21.37px;
      /* left: 100px;
      top: 178px; */
      /* background: #002efe; */
      top:73.5px;
    }
    .flat2 {
      position: absolute;
      width: 271.75px;
      height: 12.08px;
      left: 100px;
      top: 188px;
    }
    .flat3 {
      position: absolute;
      width: 259.96px;
      height: 18.11px;
      left: 120px;
      top: 180px;
    }
    .scan {
      position: absolute;
      width: 40px;
      height: 9px;
      left: 668px;
      top: 447px;

      font-family: sans-serif;
      font-style: bold;
      font-weight: 900;
      font-size: 10px;
      line-height: 9px;

      color: #002efe;
    }
    .layout-qr {
      position: absolute;
      width: 45px;
      height: 50px;
      left: 664px;
      top: 460px;

      background: #ffffff;
      border: 2px solid #002efe;
      box-sizing: border-box;
      border-radius: 5px;
    }
    .qr {
      /* position: absolute; */
      width: 100%;
      height: 100%;
      /* left: 665px;
      top: 461px; */
      border-radius: 3px;
    }
    .flat-right {
      /* position: absolute; */
      width: 372px;
      height: 23px;
      left: 721px;
      top: 376px;
    }
    .logo2 {
      width: 87px;
      height: 58px;
      margin-left: 281px;
      margin-top: -60px;
      margin-bottom: 101.9px;
    }
    .name-label {
      width: 50%;
      height: 10px;
      margin-left: 1px;
      margin-top: 2px;
      margin-bottom: 2px;

      font-family: sans-serif;
      font-style: normal;
      font-weight: 900;
      font-size: 10px;
      line-height: 5px;
      /* identical to box height */

      color: #000000;
    }
    .name-lable2 {
      width: 50%;
      height: 10px;
      margin-left: 3px;
      margin-top: 1px;

      font-family: sans-serif;
      font-style: bold;
      font-weight: 900;
      font-size: 10px;
      line-height: 5px;
    }
    .name-lable3 {
      width: 60%;
      height: 10px;
      margin-left: 6px;
      margin-top: -2px;
      margin-bottom: 1px;

      font-family: sans-serif;
      font-style: bold;
      font-weight: 900;
      font-size: 10px;
    }
    .desc {
      width: 100%;
      margin-left: 4px;
      margin-top: -100px;

      font-family: sans-serif;
      font-style: normal;
      font-size: 9px;
      line-height: 8px;

      color: #000000;
    }
    .sekretariat {
      width: 100%;
      height: 10px;
      margin-left: 20px;
      margin-top: 2px;

      font-family: sans-serif;
      font-style: bold;
      font-weight: 900;
      font-size: 10px;
      /* identical to box height */

      color: #000000;
    }
    .add {
      width: 115px;
      height: 35px;
      margin-left: 20px;
      margin-top: 2px;

      font-family: sans-serif;
      font-style: normal;
      font-size: 9px;
    }
    .label-right {
      width: 100%;
      margin-left: 229px;
      margin-top: -150px;

      font-family: sans-serif;
      font-style: bold;
      font-weight: 900;
      font-size: 8px;
    }
    .ttd {
      width: 72px;
      height: 57px;
      margin-left: 259px;
      margin-top: -16px;
    }
    .author {
      width: 72px;
      margin-left: 259px;
      margin-top: -11px;

      font-family: sans-serif;
      font-style: bold;
      font-weight: 900;
      font-size: 9px;
      line-height: 9px;
    }
    .line {
      width: 65px;
      height: 0.93px;
      margin-left: 259px;
      margin-top: -1px;

      background: #000000;
    }
    .card-name{
      position: absolute;
      width: 296px;
      margin-left: 600px;
      top: 229px;

      font-family: Seaweed Script;
      font-style: normal;
      font-weight: normal;
      font-size: 50px;
      line-height: 50px;
      /* or 83% */

      text-align: center;

      color: #0070FF;

    }
  </style>

  <body>
    <div>
      <img class="card-name" src="{{ public_path('assets/images/name-card.png') }}">
    </div>
    <div class="layout-left">
      <div class="title">KARTU TANDA ANGGOTA</div>
      <img class="logo" src="{{ public_path('assets/images/logo-aaw.png') }}" />
      <div>
        <img class="img" src="{{ public_path('storage/'.$profile->photo) }}" />
        <p class="name">{{ $profile->name }}</p>
        <p class="base">Anggota</p>
        <p class="code">{{ $profile->village->district->regency->province->id }}-{{ $profile->village->district->regency->id }}-{{ $profile->village->district->id }}-{{ $profile->number }}</p>
      </div>
       <div>
      <img class="flat1" src="{{ public_path('assets/images/flat-blue.png')}}" />
    </div>
    <div>
      <img class="flat3" src="{{ public_path('assets/images/flat3-left.png')}}" />
    </div>
    <div>
      <img class="flat2" src="{{ public_path('assets/images/flat2-left.png')}}" />
    </div>
  

    </div>
    <div class="address">
      <p>{{ $profile->address }}</p>
    </div>
    <div class="regency">
      <p>{{ $profile->village->name }},{{ $profile->village->district->name }},{{ $profile->village->district->regency->name }}</p>
    </div>
    <div class="province">
      <p>{{ $profile->village->district->regency->province->name }}</p>
    </div>

    <div class="scan">S C A N</div>
    <div class="layout-qr">
      <img class="qr" src="{{ public_path('storage/assets/user/qrcode/'.$profile->code.'.png')}}" />
    </div>
    <div class="layout-right">
      <div>
        <img class="flat-right" src="{{ public_path('assets/images/flat-right.png')}}" />
      </div>
      <div>
        <table class="name-label" cellpadding="2" cellspacing="3">
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $profile->name }}</td>
          </tr>
          <tr>
            <td>TTL</td>
            <td>:</td>
            <td>{{ $profile->place_berth }}, {{ date('d-m-Y', strtotime($profile->date_berth)) }}</td>
          </tr>
          <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $profile->nik }}</td>
          </tr>
        </table>
        <table class="name-lable2">
          <tr>
            <td>Terdaftar Tanggal</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($profile->created_at)) }}</td>
          </tr>
        </table>
        <div class="name-lable3">KARTU TANDA ANGGOTA JALUR AAW</div>
        <div>
          <img class="logo2" src="{{ public_path('assets/images/logo-aaw.png') }}" />
        </div>
        <table class="desc" cellpadding="0" cellspacing="1">
          <tr>
            <td>1.</td>
            <td>
              Pemegang Kartu ini adalaj Anggota Terdaftar pada e-KTA JALUR AAW
            </td>
          </tr>
          <tr>
            <td>2.</td>
            <td>Kartu ini adalah sebagai identitas resmi anggota JALUR AAW</td>
          </tr>
          <tr>
            <td>3.</td>
            <td>
              Dilarang menggunakan kartu ini dalam kegiatan yang melanggar hukum
            </td>
          </tr>
          <tr>
            <td>4.</td>
            <td>Kartu ini adalah hasil cetak mandiri dari KTA elektronik</td>
          </tr>
          <tr>
            <td>5.</td>
            <td>Jika menemukan kartu ini harap dikembalikan ke :</td>
          </tr>
        </table>
        <div class="sekretariat">Sekretariat JALUR AAW</div>
        <div class="add">
          Jl. Pantai Binuangeun No. 1 Muara, Wanasalam Lebak, Banten
        </div>
        <div class="label-right">JARINGAN DULUR KANG ASEP AW</div>
        <div>
          <img class="ttd" src="{{ public_path('assets/images/ttd2.png') }}" />
        </div>
        <div class="author">Asep Awaludin</div>
        <div class="line"></div>
      </div>
    </div>
  </body>
</html>
