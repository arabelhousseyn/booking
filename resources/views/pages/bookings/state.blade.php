@extends('layouts.app')

@section('title','panel - État du véhicule')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.bookings.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <h1>
            État du véhicule
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.bookings.index')}}"><i class="fa fa-users"></i> Réservations</a></li>
            <li><a class="active">État du véhicule</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">État initial</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Photo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($booking->start_photos as $start_photo)
                                <tr>
                                    <td><img src="{{$start_photo}}" width="300" height="300"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">État finale</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Photo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($booking->end_photos as $end_photo)
                                <tr>
                                    <td><img src="{{$end_photo}}" width="300" height="300"></td>
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
