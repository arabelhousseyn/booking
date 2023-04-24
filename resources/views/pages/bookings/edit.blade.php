@extends('layouts.app')

@section('title','panel - Modifier réservations')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.bookings.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.bookings.index')}}">Réservations</a></li>
            <li><a class="active">Modifier réservations</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Modifier réservations</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.bookings.update',$booking->id)}}" method="POST" role="form">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="properties">Propriétés</label>
                                <select name="bookable_id" id="properties" class="form-control">
                                    @foreach($properties as $property)
                                        <option value="{{$property->id}}">{{$property->title}}
                                            - {{$property->seller->first_name}} {{$property->seller->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Modifier</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>

    <script>
        $("#properties").select2({});
    </script>
@endsection
