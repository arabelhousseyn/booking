@extends('layouts.app')

@section('title','panel - Documents')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.vehicles.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <h1>
            Documents
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.vehicles.index')}}"><i class="fa fa-users"></i> Véhicules</a></li>
            <li><a class="active">Documents</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Documents</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Date d'expiration</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicle->documents as $document)
                                <tr>
                                    <td><b>{{$document->document_type->description}}</b></td>
                                    <td>
                                        <img src="{{$document->document_url}}" width="300" height="300">
                                    </td>
                                    <td>
                                        {{$document->expiry_date}}
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
