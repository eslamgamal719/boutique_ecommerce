<div class="card border-0 rounded-0 p-lg-4 bg-light">
    <div class="card-body">
        <h5 class="test-uppercase mb-4">Navigation</h5>

        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'frontend.customer.dashboard' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('frontend.customer.dashboard') }}">
                <strong class="small text-uppercase font-weight-bold">Dashboard</strong>
            </a>
        </div>

        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'frontend.customer.profile' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('frontend.customer.profile') }}">
                <strong class="small text-uppercase font-weight-bold">Profile</strong>
            </a>
        </div>

        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'frontend.customer.addresses' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('frontend.customer.addresses') }}">
                <strong class="small text-uppercase font-weight-bold">Addresses</strong>
            </a>
        </div>

        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'frontend.customer.orders' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('frontend.customer.orders') }}">
                <strong class="small text-uppercase font-weight-bold">Orders</strong>
            </a>
        </div>

        <div class="py-2 px-4 mb-3 pg-light">
            <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <strong class="small text-uppercase font-weight-bold">Logout</strong>
            </a>
            <form action="{{ route('logout') }}" method="post" class="d-none" id="logout-form">
                @csrf
            </form>
        </div>
    </div>
</div>