@extends('layouts.app')

@section('title','panel - Modifier Véhicule')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.vehicles.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.vehicles.index')}}">Véhicule</a></li>
            <li><a class="active">Modifier Véhicule</a></li>
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
                        <h3 class="box-title">Modifier Véhicule</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.vehicles.update',$vehicle->id)}}" method="POST" role="form">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Titre</label>
                                <input type="text" class="form-control" value="{{$vehicle->title}}" id="title" name="title"
                                       placeholder="Titre" required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Description" required>{{$vehicle->description}}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="price">Prix</label>
                                <input type="text" class="form-control" value="{{$vehicle->price}}" id="price" name="price"
                                       placeholder="Prix" required>
                                <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                            </div>


                            <div class="form-group">
                                <label for="places">Places</label>
                                <input type="text" class="form-control" value="{{$vehicle->places}}" id="places" name="places"
                                       placeholder="Places" required>
                                <x-input-error :messages="$errors->get('places')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="places">Motorisation</label>
                                <select class="form-control" id="places" name="motorisation">
                                    <option value="{{\App\Enums\Motorisation::GAS}}" @selected(\App\Enums\Motorisation::GAS == $vehicle->motorisation)>{{\App\Enums\Motorisation::GAS()->description}}</option>
                                    <option value="{{\App\Enums\Motorisation::DIESEL}}" @selected(\App\Enums\Motorisation::DIESEL == $vehicle->motorisation)>{{\App\Enums\Motorisation::DIESEL()->description}}</option>
                                    <option value="{{\App\Enums\Motorisation::GASOLINE}}" @selected(\App\Enums\Motorisation::GASOLINE == $vehicle->motorisation)>{{\App\Enums\Motorisation::GASOLINE()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('motorisation')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="gearbox">Boîte de vitesses</label>
                                <select class="form-control" id="gearbox" name="gearbox">
                                    <option value="{{\App\Enums\GearBox::MANUAL}}" @selected(\App\Enums\GearBox::MANUAL == $vehicle->gearbox)>{{\App\Enums\GearBox::MANUAL()->description}}</option>
                                    <option value="{{\App\Enums\GearBox::AUTOMATIC}}" @selected(\App\Enums\GearBox::AUTOMATIC == $vehicle->gearbox)>{{\App\Enums\GearBox::AUTOMATIC()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('motorisation')" class="mt-2"/>
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
