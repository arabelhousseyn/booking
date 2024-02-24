<header class="main-header">

    <!-- Logo -->
    <a href="{{route('dashboard')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">BK</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Booking</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        @php
            $notifications = auth()->user()->notifications;
        @endphp
            <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger">{{$notifications->count()}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Vous avez {{$notifications->count()}} notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @foreach($notifications as $notification)
                                    @if($notification->data['data']['type'] == 'booking')
                                        <li>
                                            <a href="#">
                                                {{\App\Enums\Notifications::fromValue($notification->type)->description}} N
                                                : {{$notification->data['data']['reference']}}
                                            </a>
                                        </li>
                                    @elseif($notification->data['data']['type'] == 'house' || $notification->data['data']['type'] == 'vehicle')
                                        <li>
                                            <a href="#">
                                                {{\App\Enums\Notifications::fromValue($notification->type)->description}}
                                                : {{$notification->data['data']['title']}}
                                            </a>
                                        </li>
                                    @elseif($notification->data['data']['type'] == 'seller_dispute' || $notification->data['data']['type'] == 'user_dispute')
                                        <li>
                                            @if(@$notification->data['image'])
                                                <img src="{{$notification->data['image']}}">
                                            @endif
                                            <a href="#">
                                                <p>contestataire: {{$notification->data['reporter']['first_name']}} {{$notification->data['reporter']['last_name']}}</p>
                                                {{\App\Enums\Notifications::fromValue($notification->type)->description}} N
                                                : {{$notification->data['data']['reference']}} / {{$notification->data['dispute']}}
                                            </a>
                                        </li>
                                    @elseif($notification->data['data']['type'] == 'new_seller' || $notification->data['data']['type'] == 'new_user')
                                        <li>
                                            <a href="#">
                                                {{\App\Enums\Notifications::fromValue($notification->type)->description}}
                                                : {{$notification->data['data']['first_name']}} {{$notification->data['data']['last_name']}}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
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
                <li><a href="{{route('dashboard.bookings.index')}}"><i class="fa fa-hotel"></i>
                        <span>Réservations</span></a></li>
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

            @if($permissions->contains(\App\Enums\Permissions::CAN_MANAGE_ADS))
                <li><a href="{{route('dashboard.ads.index')}}"><i class="fa fa-bullhorn"></i> <span>Publicités</span></a>
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

    <script>
        let bookingPage = {!! json_encode(route('dashboard.bookings.index')) !!};
        let housePage = {!! json_encode(route('dashboard.houses.index')) !!};
        let vehiclePage = {!! json_encode(route('dashboard.vehicles.index')) !!};
        let sellerPage = {!! json_encode(route('dashboard.sellers.index')) !!};
        let userPage = {!! json_encode(route('dashboard.users.index')) !!};
        let notificationSoundUrl = {!! json_encode(asset('assets/notification.mp3')) !!};

        // ask for notification permission
        Notification.requestPermission();

        var pusher = new Pusher('10a28b22911cdafb7485', {
            cluster: "eu",
            encrypted: true,
        });

        var channel = pusher.subscribe('booking');

        channel.bind('declined_booking', function (data) {
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouvelle réservation refusée N: ` + data.data.reference);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouvelle réservation refusée',
                    text: 'Réservation N: ' + data.data.reference,
                    icon: 'info',
                    confirmButtonText: 'Ok!'
                })

                notification.onclick = (event) => {
                    window.open(bookingPage)
                }
            }
        });

        channel.bind('terminated_booking', function (data) {
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouvelle réservation terminée N: ` + data.data.reference);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouvelle réservation terminée',
                    text: 'Réservation N: ' + data.data.reference,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                })

                notification.onclick = (event) => {
                    window.open(bookingPage)
                }
            }
        });

        channel.bind('new_house', function (data) {
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouvelle maison ajouter: ` + data.data.title);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouvelle maison ajouter',
                    text: 'Nouvelle maison ajouter: ' + data.data.title,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                })

                notification.onclick = (event) => {
                    window.open(housePage);
                }
            }
        });

        channel.bind('new_vehicle', function (data) {
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouvelle voiture ajouter: ` + data.data.title);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouvelle voiture ajouter',
                    text: 'Nouvelle voiture ajouter: ' + data.data.title,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                })

                notification.onclick = (event) => {
                    window.open(housePage);
                }
            }
        });

        channel.bind('seller_dispute', function (data) {
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouveau litige: ` + data.data.reference);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouveau litige',
                    text: 'Nouveau litige: ' + data.data.reference,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                });
            }
        });

        channel.bind('user_dispute', function (data) {
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouveau litige: ` + data.data.reference);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouveau litige',
                    text: 'Nouveau litige: ' + data.data.reference,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                });
            }
        });

        channel.bind('new_seller', function (data) {
            console.log('new_seller');
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouveau vendeur: ` + data.data.first_name + ' ' + data.data.last_name);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouveau vendeur',
                    text: 'Nouveau vendeur: ' + data.data.first_name + ' ' + data.data.last_name,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                })

                notification.onclick = (event) => {
                    window.open(sellerPage);
                }
            }
        });

        channel.bind('new_user', function (data) {
            if (Notification.permission === 'granted') {
                let notification = new Notification(`Nouveau utilisateur: ` + data.data.first_name + ' ' + data.data.last_name);

                let sound = new Audio();
                sound.src = notificationSoundUrl;
                sound.play();

                Swal.fire({
                    title: 'Nouveau utilisateur',
                    text: 'Nouveau utilisateur: ' + data.data.first_name + ' ' + data.data.last_name,
                    icon: 'success',
                    confirmButtonText: 'Ok!'
                })

                notification.onclick = (event) => {
                    window.open(userPage);
                }
            }
        });
    </script>
</aside>
