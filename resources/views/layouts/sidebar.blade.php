<div class="border-right" id="sidebar-wrapper">
          <div class="sidebar-heading text-center">
            <img src="{{ asset('assets/images/logos.png') }}" width="150" />
          </div>
          <div class="list-group list-group-flush">
            <a
              href="{{ route('home') }}"
              class="list-group-item list-group-item-action {{ (request()->is('user/home*')) ? 'active' : '' }}"
            >
              Dashboard
            </a>
            <a
              href="{{ route('member-create') }}"
              class="list-group-item list-group-item-action {{ (request()->is('user/member/create*')) ? 'active' : '' }}"
            >
              Buat Anggota Baru
            </a>
             <a class="list-group-item d-lg-none list-group-item-action" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
            </a>
          </div>
        </div>