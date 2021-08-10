@extends('layouts.app')
{{-- @push('addon-style')
    <link rel="stylesheet" href="{{asset('assets/select2/dist/css/select2.min.css')}}">
@endpush --}}
@section('content')
<!-- Section Content -->
 <div
            class="section-content section-dashboard-home mb-4"
            data-aos="fade-up"
          >
            <div class="container-fluid">
              <div class="dashboard-heading">
                <h2 class="dashboard-title">Profil</h2>
                <p class="dashboard-subtitle">
                    Informasi Detail Profil
                </p>
              </div>
              <div class="dashboard-content mt-4" id="transactionDetails">
                <div class="row">
                  <div class="col-12">
                    <form action="{{ route('user-profile-update', $profile->id) }}" id="register" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>NIK</label>
                                <input
                                  type="number"
                                  class="form-control"
                                  name="nik"
                                  value="{{ $profile->nik }}" 
                                  required
                                />
                              </div>
                              <div class="form-group">
                                <label>Nama</label>
                                <input
                                  type="text"
                                  name="name"
                                  class="form-control"
                                  value="{{ $profile->name }}"
                                />
                              </div>
                              <div class="form-group">
                                <label
                                  >Email<sup
                                    >(Kosongkan jika tidak ada)</sup
                                  ></label
                                >
                                <input
                                  type="text"
                                  class="form-control"
                                  name="email"
                                  value="{{ $profile->email }}"
                                />
                              </div>
                              <div class="form-group">
                                <label
                                  >No. Hp<sup
                                    >(Utamakan Nomor Whatsapp)</sup
                                  ></label
                                >
                                <input
                                  type="text"
                                  class="form-control"
                                  name="phone_number"
                                  autofocus
                                  value="{{ $profile->phone_number }}"
                                />
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-6">
                                    <label>Provinsi</label>
                                    <select id="provinces_id" class="form-control select2" v-model="provinces_id" v-if="provinces">
                                    <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                                  </select>
                                  </div>
                                  <div class="col-6">
                                    <label>Kabpuaten/Kota</label>
                                    <select id="regencies_id" class="form-control select2" v-model="regencies_id" v-if="regencies">
                                      <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-6">
                                    <label>Kecamatan</label>
                                    <select id="districts_id" class="form-control" v-model="districts_id" v-if="districts">
                                    <option v-for="district in districts" :value="district.id">@{{ district.name }}</option>
                                  </select>
                                  </div>
                                  <div class="col-6">
                                    <label>Desa</label>
                                    <select name="village_id" id="villages_id" class="form-control" v-model="villages_id" v-if="districts">
                                      <option v-for="village in villages" :value="village.id">@{{ village.name }}</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-6">
                                    <label>RT</label>
                                    <input
                                      type="number"
                                      name="rt"
                                      class="form-control"
                                      value="{{ $profile->rt }}"
                                    />
                                  </div>
                                  <div class="col-6">
                                    <label>RW</label>
                                    <input
                                      type="number"
                                      name="rw"
                                      class="form-control"
                                      value="{{ $profile->rw }}"
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <textarea name="address" class="form-control">{{ $profile->address }}</textarea>
                              </div>
                              <div class="form-group">
                                <label>Foto</label>
                                <input
                                  type="file"
                                  name="photo"
                                  class="form-control"
                                  autofocus
                                />
                              </div>
                              <div class="form-group">
                                <label>Foto KTP</label>
                                <input
                                  type="file"
                                  name="ktp"
                                  class="form-control"
                                  autofocus
                                />
                              </div>
                              <div class="form-group">
                                <button
                                  type="submit"
                                  class="btn btn-sm btn-sc-primary col-12"
                                >
                                  Simpan
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@push('addon-script')
{{-- <script src="{{asset('assets/select2/dist/js/select2.min.js')}}"></script> --}}
<script src="{{ asset('assets/vendor/vue/vue.js') }}"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
<script>
      // $(document).ready(function(){
      //   $(".select2").select2();
      // });
      Vue.use(Toasted);
      var register = new Vue({
        el: "#register",
        mounted() {
          AOS.init();
          this.getProvincesData();
          this.getRegenciesData();
          this.getDistrictsData();
          this.getVillagesData();
        },
        data(){
          return  {
            provinces: null,
            regencies: null,
            districts: null,
            villages:null,
            provinces_id: "{{ $profile->province_id }}",
            regencies_id: "{{ $profile->regency_id }}",
            districts_id: "{{ $profile->district_id }}",
            villages_id: "{{ $profile->village_id }}",

          }
        },
        methods:{
          getProvincesData(){
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                    .then(function(response){
                        self.provinces = response.data
                        console.log('oke');
                    })
                },
          getRegenciesData(){
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                    .then(function(response){
                        self.regencies = response.data
                    })
                },
          getDistrictsData(){
                var self = this;
                 axios.get('{{ url('api/districts') }}/' + self.regencies_id)
                    .then(function(response){
                        self.districts = response.data
                    })
          },
           getVillagesData(){
                var self = this;
                 axios.get('{{ url('api/villages') }}/' + self.districts_id)
                    .then(function(response){
                        self.villages = response.data
                    })
          },
          // checkForNikAvailability: function(){
          //   var self = this;
          //   axios.get('{{ route('api-nik-check') }}', {
          //     params:{
          //       nik:this.nik
          //     }
          //   })
          //     .then(function (response) {
          //       if(response.data == 'Available'){
          //           self.$toasted.show(
          //               "NIK telah tersedia, silahkan lanjut langkah selanjutnya!",
          //               {
          //                 position: "top-center",
          //                 className: "rounded",
          //                 duration: 2000,
          //               }
          //           );
          //           self.nik_unavailable = false;
          //       }else{
          //           self.$toasted.error(
          //             "Maaf, NIK telah terdaftar pada sistem",
          //             {
          //               position: "top-center",
          //               className: "rounded",
          //               duration: 2000,
          //             }
          //         );
          //         self.nik_unavailable = true;
          //       }
          //         // handle success
          //         console.log(response);
          //       });
          // },
        },
        watch:{
                provinces_id: function(val,oldval){
                    this.regencies_id = null;
                    this.getRegenciesData();
                },
                 regencies_id: function(val,oldval){
                    this.districts_id = null;
                    this.getDistrictsData();
                },
                districts_id: function(val,oldval){
                    this.villages_id = null;
                    this.getVillagesData();
                },
            },
      });
    </script>
@endpush