<aside
    class="main-sidebar elevation-4  {{ auth()->user()->theme_mode == 1 ? 'sidebar-dark-purple' : 'sidebar-dark-primary' }}">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link {{ auth()->user()->theme_mode == 1 ? 'bg-white' : ' bg-dark' }} ">
        <img src="{{ asset('img/logo.png') }}" alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text"><b>অ্যাডমিন</b>প্যানেল</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-child-indent nav-flat" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>ড্যাশবোর্ড</p>
                    </a>

                </li>
                <?php
                $subMenu = ['user.index', 'user.create', 'user.edit'];
                ?>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}"
                       class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users-gear"></i>
                        <p>ব্যবহারকারী</p>
                    </a>
                </li>
                <?php
                $subMenu = ['plan-service-category.index','plan-service-category.create','plan-service-category.edit']
                ?>
                <li class="nav-item">
                    <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
                       href="{{ route('plan-service-category.index') }}">
                        <i class="fa fa-wrench nav-icon"></i>
                        প্ল্যান সার্ভিস ক্যাটাগরি</a>
                </li>
                @php
                    $menu = [];
                @endphp

                <li class="nav-item {{ in_array(Route::currentRouteName(), $menu) ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ in_array(Route::currentRouteName(), $menu) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            আবেদনের প্রক্রিয়া
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        $subMenu = [];
                        ?>
                        <li class="nav-item">
                            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
                               href="#">
                                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                নতুন আবেদনের তালিকা</a>
                        </li>
                        <?php
                        $subMenu = [];
                        ?>
                        <li class="nav-item">
                            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
                               href="#">
                                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                অনুমোদিত আবেদনের তালিকা</a>
                        </li>
                        <?php
                        $subMenu = [];
                        ?>
                        <li class="nav-item">
                            <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
                               href="#">
                                <i class="far  {{  in_array(Route::currentRouteName(), $subMenu)  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                বাতিল আবেদনের তালিকা </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

</aside>
