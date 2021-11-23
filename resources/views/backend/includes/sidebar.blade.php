    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.index') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

  

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>


      @can('show_categories')
      <!-- categories -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('categories')[0] }}" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="{{ active_menu('categories')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-list-alt"></i>
          <span>Categories</span>
        </a>
        <div id="collapseOne" class="collapse {{ active_menu('categories')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.categories.index') }}">Categories</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_products')
      <!-- Products -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('products')[0] }}" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="{{ active_menu('products')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-boxes"></i>
          <span>Products</span>
        </a>
        <div id="collapseTwo" class="collapse {{ active_menu('products')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.products.index') }}">Products</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_tags')
      <!-- Tags -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('tags')[0] }}" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="{{ active_menu('tags')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-tag"></i>
          <span>Tags</span>
        </a>
        <div id="collapseThree" class="collapse {{ active_menu('tags')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.tags.index') }}">Tags</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_coupons')
      <!-- coupons -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('coupons')[0] }}" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="{{ active_menu('coupons')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-percent"></i>
          <span>Coupons</span>
        </a>
        <div id="collapseFour" class="collapse {{ active_menu('coupons')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.coupons.index') }}">Coupons</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_reviews')
      <!-- reviews -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('reviews')[0] }}" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="{{ active_menu('reviews')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-comment"></i>
          <span>Reviews</span>
        </a>
        <div id="collapseFive" class="collapse {{ active_menu('reviews')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.reviews.index') }}">Reviews</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_customers')
      <!-- customers -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('customers')[0] }}" href="#" data-toggle="collapse" data-target="#collapseSix" aria-expanded="{{ active_menu('customers')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-users"></i>
          <span>Customers</span>
        </a>
        <div id="collapseSix" class="collapse {{ active_menu('customers')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.customers.index') }}">Customers</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_orders')
      <!-- shipping companies -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('orders')[0] }}" href="#" data-toggle="collapse" data-target="#collapseThirteen" aria-expanded="{{ active_menu('orders')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-shopping-basket"></i>
          <span>Orders</span>
        </a>
        <div id="collapseThirteen" class="collapse {{ active_menu('orders')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.orders.index') }}">Orders</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_countries')
      <!-- countries -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('countries')[0] }}" href="#" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="{{ active_menu('countries')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-globe"></i>
          <span>Countries</span>
        </a>
        <div id="collapseSeven" class="collapse {{ active_menu('countries')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.countries.index') }}">Countries</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_states')
      <!-- states -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('states')[0] }}" href="#" data-toggle="collapse" data-target="#collapseEight" aria-expanded="{{ active_menu('states')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-map-marker-alt"></i>
          <span>States</span>
        </a>
        <div id="collapseEight" class="collapse {{ active_menu('states')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.states.index') }}">States</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_cities')
      <!-- cities -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('cities')[0] }}" href="#" data-toggle="collapse" data-target="#collapseNine" aria-expanded="{{ active_menu('cities')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-university"></i>
          <span>Cities</span>
        </a>
        <div id="collapseNine" class="collapse {{ active_menu('cities')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.cities.index') }}">Cities</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_customer_addresses')
      <!-- customer addresses -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('customer_addresses')[0] }}" href="#" data-toggle="collapse" data-target="#collapseTen" aria-expanded="{{ active_menu('customer_addresses')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-map-marked-alt"></i>
          <span>Customer Adresses</span>
        </a>
        <div id="collapseTen" class="collapse {{ active_menu('customer_addresses')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.customer_addresses.index') }}">Customer Adresses</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_shipping_companies')
      <!-- shipping companies -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('shipping_companies')[0] }}" href="#" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="{{ active_menu('shipping_companies')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-shipping-fast"></i>
          <span>Shipping Companies</span>
        </a>
        <div id="collapseEleven" class="collapse {{ active_menu('shipping_companies')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.shipping_companies.index') }}">Shipping Companies</a>
          </div>
        </div>
      </li>
      @endcan

      @can('show_payments')
      <!-- shipping companies -->
      <li class="nav-item">
        <a class="nav-link {{ active_menu('payment_methods')[0] }}" href="#" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="{{ active_menu('payment_methods')[1] }}" aria-controls="collapseTwo">
          <i class="fas fa-dollar-sign"></i>
          <span>Payment methods</span>
        </a>
        <div id="collapseTwelve" class="collapse {{ active_menu('payment_methods')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.payment_methods.index') }}">Payment methods</a>
          </div>
        </div>
      </li>
      @endcan



    </ul>
    <!-- End of Sidebar -->