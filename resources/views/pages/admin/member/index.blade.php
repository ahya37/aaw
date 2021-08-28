@extends('layouts.admin')
@section('title','Anggota Terdaftar')
@push('addon-style')
    <link
      href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"
      rel="stylesheet"
    />
@endpush
@section('content')
<!-- Section Content -->
 <div
            class="section-content section-dashboard-home mb-4"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Anggota Terdaftar</h2>
                <p class="dashboard-subtitle">
                </p>
              </div>
              <div class="dashboard-content mt-4" id="transactionDetails">
                
                <div class="row">
                  <div class="col-12">
                    @include('layouts.message')
                    <div class="card">
                      <div class="card-body">
                       <div class="table-responsive">
                                  <table id="data" class="table table-sm table-striped">
                                    <thead>
                                      <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Kabupaten/Kota</th>
                                        <th scope="col">Kecamatan</th>
                                        <th scope="col">Desa</th>
                                        <th scope="col">Rekomendasi Dari</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($member as $row)
                                      <tr>
                                        <td>
                                          <a href="{{ route('admin-profile-member', encrypt($row->id)) }}">
                                            <img
                                              src="{{ asset('storage/'.$row->photo) ?? ''}}"
                                              class="rounded"
                                              width="30"
                                            />
                                            {{ $row->name }}
                                          </a>
                                        </td>
                                        <td>{{ $row->village->district->regency->name ?? '' }}</td>
                                        <td>{{ $row->village->district->name ?? '' }}</td>
                                        <td>{{ $row->village->name ?? '' }}</td>
                                        <td>
                                            {{-- <img
                                              src="{{ asset('storage/'.$row->reveral->photo) ?? ''}}"
                                              class="rounded"
                                              width="30"
                                            /> --}}
                                            {{ $row->reveral->name ?? '' }}
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
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
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#data").DataTable();
      });
    </script>
@endpush