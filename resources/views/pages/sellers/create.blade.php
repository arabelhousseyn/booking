@extends('layouts.app')

@section('title','panel - Ajouter Partenaire')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.sellers.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.sellers.index')}}">Partenaires</a></li>
            <li><a class="active">Ajouter Partenaire</a></li>
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
                        <h3 class="box-title">Ajouter Partenaires</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.sellers.store')}}" method="POST" role="form">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="first_name">Prénom</label>
                                <input type="text" class="form-control" value="{{old('first_name')}}" id="first_name" name="first_name"
                                       placeholder="Prénom" required>
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Nom</label>
                                <input type="text" class="form-control" value="{{old('last_name')}} "id="last_name" name="last_name"
                                       placeholder="Nom" required>
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
                            </div>
                            <div class="form-group">
                                <label for="phone">Téléphone</label>
                                <input type="text" class="form-control" value="{{old('phone')}}" id="phone" name="phone"
                                       placeholder="Téléphone" required>
                                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                            </div>
                            <div class="form-group">
                                <label for="country_code">Code du pays</label>
                                <input type="text" class="form-control" value="{{old('country_code')}}" id="country_code" name="country_code"
                                       placeholder="Code du pays" required>
                                <x-input-error :messages="$errors->get('country_code')" class="mt-2"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" value="{{old('email')}}" id="exampleInputEmail1" name="email"
                                       placeholder="Email" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mote de passe</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                       placeholder="Mote de passe" required>
                                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="ConfirmexampleInputPassword1">Confirmer Mote de passe</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       id="ConfirmexampleInputPassword1" placeholder="Confirmer Mote de passe" required>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
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
