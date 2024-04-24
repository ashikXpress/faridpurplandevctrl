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
                $subMenu = ['area.index',
                    'area.create','area.edit']
                ?>
                <li class="nav-item">
                    <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
                       href="{{ route('area.index') }}">
                        <i class="fa fa-wrench nav-icon"></i>
                        মহল্লা</a>
                </li>

                <?php
                $subMenu = ['supporting-document-category.index',
                    'supporting-document-category.create','supporting-document-category.edit']
                ?>
                <li class="nav-item">
                    <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
                       href="{{ route('supporting-document-category.index') }}">
                        <i class="fa fa-wrench nav-icon"></i>
                        সাপোর্টিং ডকুমেন্ট ক্যাটাগরি</a>
                </li>
                <?php
                $subMenu = ['plan-service-category.index',
                    'plan-service-category.create',
                    'plan-service-category.edit',
                    'add-plan-service-category-supporting-document-items']
                ?>
                <li class="nav-item">
                    <a class="nav-link {{ in_array(Route::currentRouteName(), $subMenu) ? 'active' : '' }}"
                       href="{{ route('plan-service-category.index') }}">
                        <i class="fa fa-wrench nav-icon"></i>
                        প্ল্যান সার্ভিস ক্যাটাগরি</a>
                </li>
                @php
                    $planServiceCategories = \App\Models\PlanServiceCategory::where('status',1)
                               ->orderBy('sort')->get();
                       $menu = ['plan_service_order'];
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
                        <li class="nav-item {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::PENDING ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        নতুন আবেদনের তালিকা
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                   @foreach($planServiceCategories as $planServiceCategory)
                                    <li class="nav-item">
                                        <a  class="nav-link  {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::PENDING && request('planServiceCategory') == $planServiceCategory->id  ? 'active' : '' }}" href="{{ route('plan_service_order',['planServiceCategory'=>$planServiceCategory->id,'status'=>\App\Enumeration\ServiceOrderStatus::PENDING]) }}">
                                            <i class="far  {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::PENDING && request('planServiceCategory') == $planServiceCategory->id  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                            <p>{{ $planServiceCategory->name }}</p>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        <li class="nav-item {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::APPROVED ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p style="font-size: 12px">
                                        অনুমোদিত আবেদনের তালিকা
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach($planServiceCategories as $planServiceCategory)
                                        <li class="nav-item">
                                            <a  class="nav-link  {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::APPROVED && request('planServiceCategory') == $planServiceCategory->id  ? 'active' : '' }}" href="{{ route('plan_service_order',['planServiceCategory'=>$planServiceCategory->id,'status'=>\App\Enumeration\ServiceOrderStatus::APPROVED]) }}">
                                                <i class="far  {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::APPROVED && request('planServiceCategory') == $planServiceCategory->id  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>{{ $planServiceCategory->name }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        <li class="nav-item {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::REJECTED ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        বাতিল আবেদনের তালিকা
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach($planServiceCategories as $planServiceCategory)
                                        <li class="nav-item">
                                            <a  class="nav-link  {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::REJECTED && request('planServiceCategory') == $planServiceCategory->id  ? 'active' : '' }}" href="{{ route('plan_service_order',['planServiceCategory'=>$planServiceCategory->id,'status'=>\App\Enumeration\ServiceOrderStatus::REJECTED]) }}">
                                                <i class="far  {{ in_array(Route::currentRouteName(), $menu) && request('status') == \App\Enumeration\ServiceOrderStatus::REJECTED && request('planServiceCategory') == $planServiceCategory->id  ? 'fa-check-circle' : 'fa-circle' }} nav-icon"></i>
                                                <p>{{ $planServiceCategory->name }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

</aside>
