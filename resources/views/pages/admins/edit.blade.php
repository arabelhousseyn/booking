@extends('layouts.app')

@section('title','panel - Modifier Administrateur')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.admins.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.admins.index')}}">Administrateurs</a></li>
            <li><a class="active">Modifier Administrateur</a></li>
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
                        <h3 class="box-title">Modifier Administrateur</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.admins.update',$admin->id)}}" method="POST" role="form">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="full_name">Nom complète</label>
                                <input type="text" class="form-control" id="full_name" value="{{$admin->full_name}}" name="full_name"
                                       placeholder="Nom complète" required>
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" value="{{$admin->email}}" name="email"
                                       placeholder="Email" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
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
