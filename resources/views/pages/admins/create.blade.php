@extends('layouts.app')

@section('title','panel - Ajouter Administrateur')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.admins.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.admins.index')}}">Administrateurs</a></li>
            <li><a class="active">Ajouter Administrateur</a></li>
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
                        <h3 class="box-title">Ajouter Administrateur</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.admins.store')}}" method="POST" role="form">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="full_name">Nom complète</label>
                                <input type="text" class="form-control" id="full_name" name="full_name"
                                       placeholder="Nom complète" required>
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email"
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

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select id="role" name="role" class="form-control" required>
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2"/>
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
