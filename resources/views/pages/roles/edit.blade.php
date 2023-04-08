@extends('layouts.app')

@section('title','panel - Modifier un rôle')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.roles.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.roles.index')}}">Rôles</a></li>
            <li><a class="active">Modifier un rôle</a></li>
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
                        <h3 class="box-title">Modifier un rôle</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.roles.update',$role->id)}}" method="POST" role="form">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">rôle</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="rôle" value="{{$role->name}}" required>
                                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="permissions">Permissions</label>
                                <select name="permissions[]" id="permissions1" class="form-control" multiple>
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}" @selected($role->permissions()->where('id','=',$permission->id)->exists())>{{\App\Enums\Permissions::fromValue($permission->name)->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>

    <script>
        $("#permissions1").select2({
            multiple: true,
        });
    </script>
@endsection
