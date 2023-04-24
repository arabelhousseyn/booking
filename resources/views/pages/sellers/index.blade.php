@extends('layouts.app')

@section('title','panel - Administrateurs')
@section('content')
    <section class="content-header">
        <h1>
            Partenaires
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Partenaires</a></li>
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
                        <h3 class="box-title">Partenaires</h3>
                        <a href="{{route('dashboard.sellers.create')}}" class="btn btn-primary" style="float: right;"><i
                                class="fa fa-plus"></i>
                            Ajouter</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="sellers" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date de vérification email</th>
                                <th>Téléphone</th>
                                <th>Date de vérification Téléphone</th>
                                <th>Code du pays</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sellers as $seller)
                                <tr>
                                    <td>{{$seller->first_name}}</td>
                                    <td>{{$seller->last_name}}</td>
                                    <td>{{$seller->email}}</td>
                                    <td>{{$seller->email_verified_at}}</td>
                                    <td>{{$seller->phone}}</td>
                                    <td>{{$seller->phone_verified_at}}</td>
                                    <td>+{{$seller->country_code}}</td>
                                    <td>{{$seller->created_at->format('Y-m-d H:i:s')}}</td>
                                    <td style="display: flex;flex-direction: row;">
                                        <a href="{{route('dashboard.sellers.edit',$seller->id)}}" class="btn btn-success"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{route('dashboard.sellers.destroy',$seller->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" id="delete-seller" value="{{$seller->id}}" class="btn btn-danger"><i class="fa fa-minus"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;">
                            {{$sellers->links()}}
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
            $('#sellers').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'sorting': false,
                'order': [[7, 'desc']],
                'info': true,
                'autoWidth': false
            })

            $('#delete-seller').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
