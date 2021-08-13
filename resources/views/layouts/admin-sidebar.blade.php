<div class="border-right" id="sidebar-wrapper">
          <div class="sidebar-heading text-center">
            <img src="{{ asset('assets/images/logos.svg') }}" class="my-4" width="100" />
          </div>
          <div class="list-group list-group-flush">
            <a
              href="{{ route('admin-dashboard') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/dashboard')) ? 'active' : '' }}"
            >
              Dashboard
            </a>
            <a
              href="{{ route('admin-member') }}"
              class="list-group-item list-group-item-action {{ (request()->is('admin/member*')) ? 'active' : '' }}"
            >
              Anggota Terdaftar
            </a>
          </div>
        </div>