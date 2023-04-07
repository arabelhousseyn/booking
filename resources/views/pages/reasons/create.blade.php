@extends('layouts.app')

@section('title','panel - Ajouter Raison')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.reasons.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.reasons.index')}}">Raisons de réclamation</a></li>
            <li><a class="active">Ajouter Raison</a></li>
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
                        <h3 class="box-title">Ajouter Raison</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.reasons.store')}}" method="POST" role="form">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Description" required></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="types">Types</label>
                                <select id="types" name="type" class="form-control">
                                    <option value="{{\App\Enums\ReasonTypes::ALL}}">{{\App\Enums\ReasonTypes::ALL()->description}}</option>
                                    <option value="{{\App\Enums\ReasonTypes::VEHICLES}}">{{\App\Enums\ReasonTypes::VEHICLES()->description}}</option>
                                    <option value="{{\App\Enums\ReasonTypes::HOUSES}}">{{\App\Enums\ReasonTypes::HOUSES()->description}}</option>
                                </select>
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
