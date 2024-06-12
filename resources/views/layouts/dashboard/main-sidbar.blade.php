       <!-- Main Sidebar Container -->
       <aside class="main-sidebar sidebar-dark-primary elevation-4">
           <!-- Brand Logo -->
           <a href="index3.html" class="brand-link">
               <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                   class="brand-image img-circle elevation-3" style="opacity: .8">
               <span class="brand-text font-weight-light">AdminLTE 3</span>
           </a>

           <!-- Sidebar -->
           <div class="sidebar">
               <!-- Sidebar user panel (optional) -->
               <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                   <div class="image">
                       <img src="{{ asset('uploads/users_image/' . auth()->user()->img) }}"
                           class="img-circle elevation-2" alt="User Image">
                   </div>
                   <div class="info">
                       <a href="#"
                           class="d-block">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
                   </div>
               </div>
               <ul class="navbar-nav ">
                   <li class="nav-item">
                       <a href="{{ route('dashboard.index') }}" class="nav-link">
                           <i class="nav-icon fas fa-th"></i>
                           <span class="ml-1">Dashboard</span>
                       </a>
                   </li>
                   <li class="nav-item">
                       @if (auth()->user()->hasPermission('categories_read'))
                           <a href="{{ route('dashboard.categories.index') }}" class="nav-link">
                               <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Categories</span>
                           </a>
                       @else
                           <a class="btn disabled"> <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Categories</span></a>
                       @endif
                   </li>
                   <li class="nav-item">
                       @if (auth()->user()->hasPermission('products_read'))
                           <a href="{{ route('dashboard.products.index') }}" class="nav-link">
                               <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Products</span>
                           </a>
                       @else
                           <a class="btn disabled"> <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Products</span></a>
                       @endif
                   </li>

                   <li class="nav-item">
                       @if (auth()->user()->hasPermission('clients_read'))
                           <a href="{{ route('dashboard.clients.index') }}" class="nav-link">
                               <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Clients</span>
                           </a>
                       @else
                           <a class="btn disabled"> <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Clients</span></a>
                       @endif
                   </li>
                   <li class="nav-item">
                       @if (auth()->user()->hasPermission('orders_read'))
                           <a href="{{ route('dashboard.orders.index') }}" class="nav-link">
                               <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Orders</span>
                           </a>
                       @else
                           <a class="btn  disabled"> <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Orders</span></a>
                       @endif
                   </li>


                   <li class="nav-item">
                       @if (auth()->user()->hasPermission('users_read'))
                           <a href="{{ route('dashboard.users.index') }}" class="nav-link">
                               <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Users</span>
                           </a>
                       @else
                           <a class="btn disabled"> <i class="nav-icon fas fa-th"></i>
                               <span class="ml-1">Users</span></a>
                       @endif
                   </li>
               </ul>
               </nav>
               <!-- /.sidebar-menu -->
           </div>
           <!-- /.sidebar -->
       </aside>
