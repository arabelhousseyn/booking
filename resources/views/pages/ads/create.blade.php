@extends('layouts.app')

@section('title','panel - Ajouter des publicités')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.ads.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.ads.index')}}">Publicités</a></li>
            <li><a class="active">Ajouter des publicités</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ajouter des publicités</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.ads.store')}}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="permissions">Photos</label>
                                <input type="file" class="form-control" multiple name="photos[]" id="photos" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
@endsection
