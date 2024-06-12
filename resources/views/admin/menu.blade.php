<div class="sidebar">
   <!-- Sidebar user panel (optional) -->
   <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
         <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
         <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
   </div>
   <!-- Sidebar Menu -->
   <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
         <li class="nav-item menu-open">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
               <i class="nav-icon fas fa-tachometer-alt"></i>
               <p>
                  Dashboard
               </p>
            </a>

         </li>
         <li class="nav-item" >
            <a href="{{ route('fruit_category') }}" class="nav-link {{ request()->segment(2) == 'fruit-category' ? 'active' : '' }}">
               <i class="nav-icon fas fa-list"></i>
               <p>Fruit Category</p>
            </a>
         </li>

         <li class="nav-item" >
            <a href="{{ route('fruit_item') }}" class="nav-link {{ request()->segment(2) == 'fruit-item' ? 'active' : '' }}">
               <i class="nav-icon fas fa-apple-alt"></i>
               <p>Fruit Item</p>
            </a>
         </li>

         <li class="nav-item" >
            <a href="{{ route('invoice') }}" class="nav-link {{ request()->segment(2) == 'invoice' ? 'active' : '' }}">
               <i class="nav-icon fas fa-file-invoice"></i>
               <p>Invoice</p>
            </a>
         </li>
      </ul>
   </nav>
</div>
