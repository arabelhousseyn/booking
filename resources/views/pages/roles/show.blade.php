@extends('layouts.app')

@section('title','panel - Permissions')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.roles.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <h1>
            Permissions
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.roles.index')}}"><i class="fa fa-users"></i> Rôles</a></li>
            <li><a class="active">Permissions</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Permissions</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Permission</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role->permissions as $permission)
                                <tr>
                                    <td>{{\App\Enums\Permissions::fromValue($permission->name)->description}}</td>
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
@endsection
