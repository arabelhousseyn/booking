@extends('layouts.app')

@section('title','panel - Modifier Raison')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.reasons.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.reasons.index')}}">Administrateurs</a></li>
            <li><a class="active">Modifier Raison</a></li>
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
                        <h3 class="box-title">Modifier Raison</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.reasons.update',$reason->id)}}" method="POST" role="form">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Description" required>{{$reason->description}}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="types">Types</label>
                                <select id="types" name="type" class="form-control">
                                    <option value="{{\App\Enums\ReasonTypes::ALL}}" @selected($reason->type == \App\Enums\ReasonTypes::ALL)>{{\App\Enums\ReasonTypes::ALL()->description}}</option>
                                    <option value="{{\App\Enums\ReasonTypes::VEHICLES}}" @selected($reason->type == \App\Enums\ReasonTypes::VEHICLES)>{{\App\Enums\ReasonTypes::VEHICLES()->description}}</option>
                                    <option value="{{\App\Enums\ReasonTypes::HOUSES}}" @selected($reason->type == \App\Enums\ReasonTypes::HOUSES)>{{\App\Enums\ReasonTypes::HOUSES()->description}}</option>
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
@endsection
