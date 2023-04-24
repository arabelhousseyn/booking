@extends('layouts.app')

@section('title','panel - Rôles')
@section('content')
    <section class="content-header">
        <h1>
            Rôles
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Rôles</a></li>
        </ol>
    </section>

    @if(session()->has('created'))
        <div class="alert alert-success">
            {{session()->get('created')}}
        </div>
        {{session()->remove('created')}}
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Rôles</h3>
                        <a href="{{route('dashboard.roles.create')}}" class="btn btn-primary" style="float: right;"><i
                                class="fa fa-plus"></i>
                            Ajouter</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="roles" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Rôle</th>
                                <th>Permissions</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td><a href="{{route('dashboard.roles.show',$role->id)}}" class="btn btn-success">Voir permissions</a></td>
                                    <td>{{$role->created_at->format('Y-m-d H:i:s')}}</td>
                                    <td style="display: flex;flex-direction: row;">
                                        <a href="{{route('dashboard.roles.edit',$role->id)}}" class="btn btn-success"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{route('dashboard.roles.destroy',$role->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" id="delete-role" value="{{$role->id}}" class="btn btn-danger"><i class="fa fa-minus"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
            $('#delete-role').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
