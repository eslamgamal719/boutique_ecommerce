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
          <i class="fas fa-file"></i>
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
          <i class="fas fa-file"></i>
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
          <i class="fas fa-file"></i>
          <span>Tags</span>
        </a>
        <div id="collapseThree" class="collapse {{ active_menu('tags')[2] }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.tags.index') }}">Tags</a>
          </div>
        </div>
      </li>
      @endcan

    </ul>
    <!-- End of Sidebar -->