@extends('layouts.app')
@push('addon-style')
    {{-- <link
      href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"
      rel="stylesheet"
    /> --}}
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.3.0/font-awesome-animation.css" integrity="sha512-OodagY/LAbXf1TAkypAk+8OWjR+wGA8k3H7TGH+gku7+VsOmJRCQ2pTQJoTo/bATGwTOFdypCXqMV8snRZkC+w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      {{-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/> --}}
    <style>
      #idcard {
        width: 565px;
        height: 350px;
        margin: auto;
        margin-right: 250px;
        background-image: url("{{ url('assets/images/card2.png') }}");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        -webkit-print-color-adjust: exact;
    }
    #img {
        margin-top: 28px;
        margin-left: 10px;
        border-radius: 8px; /* Rounded border */
        padding: 5px; /* Some padding */
        width: 110px; /* Set a small width */
        height: 200px;
        /* margin:10px; */
    }
    #qr {
        margin-top: -100px;
        margin-left: 430px;
        border-radius: 8px; /* Rounded border */
        border-style: solid;
        border-color: #002efe;
        padding: 5px; /* Some padding */
        width: 100px; /* Set a small width */
        height: 100px;
        /* margin:10px; */
    }
    .texts-left {
        margin-top: 40px;
        width: 500%;
        font-size: 12px;
    }
    .address {
        margin-right: 120px;
        margin-left: 20px;
        /* margin-top: 2px; */
        font-size: 12px;
         width: 200%;
    }
    
    </style>
@endpush
@section('title','Dashboard')
@section('content')
          <!-- Section Content -->
          <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Dashboard</h2>
                <p class="dashboard-subtitle">Sistem Keanggotaan AAW</p>
              </div>
              <div class="dashboard-content">
                <div class="row">
                  <div class="col-md-3">
                      <div class="card mb-2">
                        <div class="card-body">
                          <div class="dashboard-card-title">Jumlah Anggota</div>
                          <div class="dashboard-card-subtitle">
                            <h5>{{ $total_member }}</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <div class="card mb-2">
                        <div class="card-body">
                          <nav>
                              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Profil</a>
                                <a class="nav-link" id="nav-member-tab" data-toggle="tab" href="#nav-member" role="tab" aria-controls="nav-contact" aria-selected="false">Anggota Ku</a>
                                <a class="nav-link" id="nav-kta-tab" data-toggle="tab" href="#nav-kta" role="tab" aria-controls="nav-kta" aria-selected="false">KTA</a>
                                <a class="nav-link" id="nav-rev-rev" data-toggle="tab" href="#nav-rev" role="tab" aria-controls="nav-kta" aria-selected="false">Reveral Ku</a>

                              </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                              <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="col-12 text-center mt-4">
                                  @if($profile->photo == null)
                                  <img src="{{ asset('assets/images/unphoto.svg') }}" class="w-70 mb-3" />
                                  @else
                                  <img src="{{ asset('storage/'.$profile->photo)}}" width="200" class="rounded mb-3 img-thumbnail" />
                                  @endif
                                  <div class="text-center">
                                      <a
                                      href="{{ route('user-profile-edit', encrypt($profile->id)) }}"
                                      class="btn btn-sm btn-sc-primary btn-lg"
                                    >
                                      Edit Profil
                                    </a>

                                  </div>
                                </div>
                                <div class="row mt-4">
                                  <div class="col-4">
                                        <div class="product-title">NIK</div>
                                        <div class="product-subtitle">{{ $profile->nik }}</div>
                                        <div class="product-title">Nama</div>
                                        <div class="product-subtitle">{{ $profile->name}}</div>
                                        <div class="product-title">Desa</div>
                                        <div class="product-subtitle">{{ $profile->village->name}}</div>
                                        <div class="product-title">Kecamatan</div>
                                        <div class="product-subtitle">{{ $profile->village->district->name}}</div>
                                        <div class="product-title">Kabupaten/Kota</div>
                                        <div class="product-subtitle">{{ $profile->village->district->regency->name}}</div>
                                        <div class="product-title">Provinsi</div>
                                        <div class="product-subtitle">{{ $profile->village->district->regency->province->name}}</div>
                                        <div class="product-title">Alamat</div>
                                        <div class="product-subtitle">{{ $profile->address}}, {{'RT '. $profile->rt}}, {{'RW '. $profile->rw}}</div>
                                        <div class="product-title">Reveral dari</div>
                                        <div class="product-subtitle">{{ $profile->reveral->name }}</div>
                                    </div>
                                    <div class="col-4">
                                      <div class="product-title">Status Pekerjaan</div>
                                      <div class="product-subtitle">{{ $profile->job->name }}</div>
                                      <div class="product-title">Pendidikan</div>
                                      <div class="product-subtitle">{{ $profile->education->name }}</div>
                                      <div class="product-title">Agama</div>
                                      <div class="product-subtitle">{{ $profile->religion ?? '' }}</div>
                                      
                                    </div>
                                    <div class="col-4">
                                      <div class="product-title">Telpon</div>
                                      <div class="product-subtitle">{{ $profile->phone_number }}</div>
                                      <div class="product-title">Whatsapp</div>
                                      <div class="product-subtitle">{{ $profile->whatsapp }}</div>
                                      <div class="product-title">EMail</div>
                                      <div class="product-subtitle">{{ $profile->email ?? '' }}</div>
                                      
                                    </div>
                                </div>
                              </div>
                              <div class="tab-pane fade mt-4" id="nav-member" role="tabpanel" aria-labelledby="nav-member-tab">
                                <div class="col-12 mb-4">
                                  <a href="{{ route('user-member-downloadpdf') }}" class="btn btn-sm btn-sc-primary text-white">Download</a>
                                </div>
                                <div class="table-responsive">
                                  <table id="data" class="table table-sm table-striped" width="100%">
                                    <thead>
                                      <tr>
                                        <th>Nama</th>
                                        <th>Kabupaten/Kota</th>
                                        <th>Kecamatan</th>
                                        <th>Desa</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      {{-- @foreach ($member as $row)
                                      <tr>
                                        <td>
                                          <a href="{{ route('member-mymember', encrypt($row->id)) }}">
                                            <img
                                              src="{{ asset('storage/'.$row->photo) }}"
                                              class="rounded"
                                              width="40"
                                            />
                                            {{ $row->name }}
                                          </a>
                                        </td>
                                        <td>{{ $row->village->district->regency->name ?? ''}}</td>
                                        <td>{{ $row->village->district->name ?? ''}}</td>
                                        <td>{{ $row->village->name ?? ''}}</td>
                                      </tr>
                                      @endforeach --}}
                                    </tbody>
                                  </table>
                                </div>
                              </div>

                              <div class="tab-pane fade mt-4" id="nav-kta" role="tabpanel" aria-labelledby="nav-kta-tab">
                                <div class="col-12 text-right mb-2">
                                  <a href="{{ route('member-card-download', $profile->id) }}" class="btn btn-sm btn-sc-primary text-white">Download KTA</a>
                                </div>
                                <div class="col-md-12 col-sm-12 text-center mb-3">
                                   <div id="idcard">
                                    <div class="col-md-12">
                                      <div class="row">
                                        <div class="col-md-5 col-sm-5">
                                          <table border="0">
                                            <tr>
                                              <td>
                                                <div id="img">
                                                  <img
                                                    class="img-thumbnail"
                                                    style="
                                                      border-radius: 8px;
                                                      width: 100%;
                                                      height: 135px;
                                                      margin: 40px 0 25px 0;
                                                    "
                                                    src="{{ asset('storage/'.$profile->photo) }}"
                                                  />
                                                </div>
                                              </td>
                                              <td align="left">
                                                <p class="texts-left">
                                                  <b> {{ $profile->name }} </b>
                                                  <br />
                                                  <b style="color: red"> Anggota </b>
                                                  <br />
                                                  <br />
                                                  <b style="color: black">
                                                   {{ $profile->village->district->regency->province->id }}-{{ $profile->village->district->regency->id }}-{{ $profile->village->district->id }}-{{ $profile->number }}
                                                  </b>
                                                </p>
                                              </td>
                                            </tr>
                                          </table>
                                          <table
                                            border="0"
                                            class="address"
                                            cellpadding="0"
                                          >
                                            <tr align="left">
                                              <td>{{ $profile->village->name  ?? ''}}</td>
                                            </tr>
                                            <tr align="left">
                                              <td>{{ $profile->village->district->name ?? '' }}, {{ $profile->village->district->regency->name ?? '' }}</td>
                                            </tr>
                                            <tr align="left">
                                              <td>
                                                <b> {{ $profile->village->district->regency->province->name ?? '' }} </b>
                                              </td>
                                            </tr>
                                          </table>
                                          <div id="qr">
                                            <img
                                              class="img-thumbnail"
                                              src="{{ asset('storage/assets/user/qrcode/'.$profile->code.'.png') }}"
                                            />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="tab-pane fade mt-4" id="nav-rev" role="tabpanel" aria-labelledby="nav-rev-tab">
                                <div class="col-12 text-center mb-3">
                                  <img width="150" src="{{ asset('storage/assets/user/qrcode/'.$profile->code.'.png') }}">
                                  <p class="text-center">{{ $profile->code }}</p>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@push('addon-script')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
<script>
      // $(document).ready(function () {
      //   $("#data").DataTable();
      // });
      var datatable = $('#data').DataTable({
            processing: true,
            language:{
              processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'
            },
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns:[
                {data: 'photo', name:'photo'},
                {data: 'regency', name:'regency'},
                {data: 'district', name:'district'},
                {data: 'village', name:'village'},
                {
                    data: 'action', 
                    name:'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },
            ]
        });
</script>
    
@endpush