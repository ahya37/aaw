<div class="border-right" id="sidebar-wrapper">
          <div class="sidebar-heading text-center">
            <img src="{{ asset('assets/images/logos.svg') }}" class="my-4" width="100" />
          </div>
          <div class="list-group list-group-flush">
            <a
              href="{{ route('home') }}"
              class="list-group-item list-group-item-action {{ (request()->is('user/home')) ? 'active' : '' }}"
            >
              Dashboard
            </a>
            <a
              href="{{ route('member-create') }}"
              class="list-group-item list-group-item-action {{ (request()->is('user/member/create')) ? 'active' : '' }}"
            >
              Buat Anggota Baru
            </a>
          </div>
        </div>