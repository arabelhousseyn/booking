@extends('layouts.app')

@section('title','panel - Photos des réclamations')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.bookings.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <h1>
            Photos des réclamations
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.bookings.index')}}"><i class="fa fa-users"></i> Réservations</a></li>
            <li><a class="active">Photos des réclamations</a></li>
        </ol>
    </section>

    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Note!</h4>
        <p>{{$booking->note}}</p>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Photos des réclamations</h3>
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
                            @foreach($booking->feedback_photos as $feedback_photo)
                                <tr>
                                    <td><img src="{{$feedback_photo}}" width="300" height="300"></td>
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
