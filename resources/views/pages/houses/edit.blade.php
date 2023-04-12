@extends('layouts.app')

@section('title','panel - Modifier Maison')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.houses.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.houses.index')}}">Maison</a></li>
            <li><a class="active">Modifier Maison</a></li>
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
                        <h3 class="box-title">Modifier Maison</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.houses.update',$house->id)}}" method="POST" role="form">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Titre</label>
                                <input type="text" class="form-control" value="{{$house->title}}" id="title" name="title"
                                       placeholder="Titre" required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Description" required>{{$house->description}}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="price">Prix</label>
                                <input type="text" class="form-control" value="{{$house->price}}" id="price" name="price"
                                       placeholder="Prix" required>
                                <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                            </div>


                            <div class="form-group">
                                <label for="rooms">Nbr de chambre</label>
                                <input type="text" class="form-control" value="{{$house->rooms}}" id="rooms" name="rooms"
                                       placeholder="Places" required>
                                <x-input-error :messages="$errors->get('rooms')" class="mt-2"/>
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
@endsection
