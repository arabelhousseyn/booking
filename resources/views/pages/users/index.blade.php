@extends('layouts.app')

@section('title','panel - Utilisateurs')
@section('content')
    <section class="content-header">
        <h1>
            Utilisateurs
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Utilisateurs</a></li>
        </ol>
    </section>

    @if(session()->has('created'))
        <div class="alert alert-success">
            {{session()->get('created')}}
        </div>
        @php
            session()->remove('created')
        @endphp
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Utilisateurs</h3>
                        <a href="{{route('dashboard.users.create')}}" class="btn btn-primary" style="float: right;"><i
                                class="fa fa-plus"></i>
                            Ajouter</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date de vérification email</th>
                                <th>Téléphone</th>
                                <th>Date de vérification Téléphone</th>
                                <th>Code du pays</th>
                                <th>Louer un véhicule</th>
                                <th>Louer une maison</th>
                                <th>Documents</th>
                                <th>Validé à</th>
                                <th>Validé par</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->first_name}}</td>
                                    <td>{{$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->email_verified_at}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->phone_verified_at}}</td>
                                    <td>+{{$user->country_code}}</td>
                                    <td>
                                        @if($user->can_rent_vehicle)
                                                <span class="alert alert-success">Oui</span>
                                        @else
                                            <span class="alert alert-danger">Non</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->can_rent_house)
                                            <span class="alert alert-success">Oui</span>
                                        @else
                                            <span class="alert alert-danger">Non</span>
                                        @endif
                                    </td>
                                    <td><a href="{{route('dashboard.users.show',$user->id)}}" class="btn btn-success"><i class="fa fa-paperclip"></i> Voir Documents</a></td>
                                    <td>{{$user->validated_at?->format('Y-m-d')}}</td>
                                    <td>{{$user->validatedBy?->full_name}}</td>
                                    <td>{{$user->created_at?->format('Y-m-d H:i:s')}}</td>
                                    <td style="display: flex;flex-direction: row;">
                                        @if(!$user->is_validated)
                                            <form action="{{route('dashboard.users.validate',$user->id)}}" method="post">
                                                @method('put')
                                                @csrf
                                                <button type="submit" id="validate-user" value="{{$user->id}}"
                                                        class="btn btn-success"><i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-success"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" id="delete-user" value="{{$user->id}}"
                                                    class="btn btn-danger"><i class="fa fa-minus"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;">
                            {{$users->links()}}
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <script>
        $(function () {
            $('#users').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'sorting': false,
                'order': [[12, 'desc']],
                'info': true,
                'scrollResize': true,
                'scrollX': true,
                'scrollY': true,
                'scrollCollapse': true,
            })

            $('#delete-user').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })

            $('#validate-user').click(function (e){
                let response = confirm('Voulez vous valider ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
