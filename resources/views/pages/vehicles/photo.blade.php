@extends('layouts.app')

@section('title','panel - Photos')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.vehicles.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <h1>
            Photos
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.vehicles.index')}}"><i class="fa fa-users"></i> Véhicules</a></li>
            <li><a class="active">Photos</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Photos</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Image</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicle->photos as $photo)
                                <tr>
                                    <td>
                                        <img src="{{$photo}}" width="300" height="300">
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
@endsection
