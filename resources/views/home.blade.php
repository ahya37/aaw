@extends('layouts.app')
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
                  <div class="col-md-8">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="dashboard-card-title">
                          Informasi Diri
                          <br />
                          <strong>Koordinator RT 01</strong>
                        </div>
                        <div class="dashboard-card-subtitle">
                          <table>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>Jhon Doe</td>
                            </tr>
                            <tr>
                              <td>Desa</td>
                              <td>:</td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>kecamatan</td>
                              <td>:</td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Provinsi</td>
                              <td>:</td>
                              <td></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="dashboard-card-title">Jumlah Anggota</div>
                        <div class="dashboard-card-subtitle">
                          <h5>40</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection