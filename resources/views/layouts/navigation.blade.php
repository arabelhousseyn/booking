<header class="main-header">

    <!-- Logo -->
    <a href="{{route('dashboard')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">Booking</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Booking</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{auth()->user()->full_name}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle"
                                 alt="User Image">

                            <p>
                                {{auth()->user()->full_name}}
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <form action="{{route('logout')}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-default btn-flat">Se déconnecter</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>

    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{auth()->user()->full_name}}</p>
            </div>
        </div>
        @php
            $permissions = collect(auth()->user()->getPermissionsViaRoles()->pluck('name'));
        @endphp
            <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_DASHBOARD))
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> <span>Tableau de bord</span></a>
                </li>
            @endif

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_ACCOUNTS))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Comptes</span>
                    </a>
                    <ul class="treeview-menu">
                        @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_ACCOUNTS__ADMINS))
                            <li><a href="{{route('dashboard.admins.index')}}"><i class="fa fa-circle-o"></i>
                                    Administrateurs</a>
                            </li>
                        @endif
                        @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_ACCOUNTS__USERS))
                            <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-circle-o"></i> Utilisateurs</a>
                            </li>
                        @endif
                        @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_ACCOUNTS__PARTNERS))
                            <li><a href="{{route('dashboard.sellers.index')}}"><i class="fa fa-circle-o"></i>
                                    Partenaires</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_HOUSES))
                <li><a href="{{route('dashboard.houses.index')}}"><i class="fa fa-home"></i> <span>Maisons</span></a>
                </li>
            @endif

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_VEHICLES))
                <li><a href="{{route('dashboard.vehicles.index')}}"><i class="fa fa-car"></i> <span>Véhicules</span></a>
                </li>
            @endif

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_BOOKINGS))
                <li><a href="{{route('dashboard.bookings.index')}}"><i class="fa fa-hotel"></i> <span>Réservations</span></a></li>
            @endif

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_PROMO_CODES))
                <li><a href="{{route('dashboard.coupons.index')}}"><i class="fa fa-gift"></i>
                        <span>Promo code</span></a>
                </li>
            @endif

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_REVIEWS))
                <li><a href="{{route('dashboard.reviews.index')}}"><i class="fa fa-star"></i> <span>Commentaires</span></a>
                </li>
            @endif

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_SETTINGS))
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                    <ul class="treeview-menu">
                        @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_SETTINGS__GENERAL))
                            <li><a href="{{route('dashboard.settings.general')}}"><i class="fa fa-circle-o"></i> Général</a>
                            </li>
                        @endif

                        @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_SETTINGS__RECLAMATIONS))
                            <li><a href="{{route('dashboard.reasons.index')}}"><i class="fa fa-circle-o"></i> Raisons de
                                    réclamation</a>
                            </li>
                        @endif

                        @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_SETTINGS__ROLES))
                            <li><a href="{{route('dashboard.roles.index')}}"><i class="fa fa-circle-o"></i> Rôles et
                                    permissions</a>
                            </li>
                        @endif

                        @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_SETTINGS__NOTIFICATIONS))
                            <li><a href="{{route('dashboard.notificationTemplate.index')}}"><i
                                        class="fa fa-circle-o"></i>
                                    Modèle de notification</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
