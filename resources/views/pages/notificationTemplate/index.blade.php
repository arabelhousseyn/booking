@extends('layouts.app')

@section('title','panel - Modèle de notification')
@section('content')
    <section class="content-header">
        <h1>
            Modèle de notification
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Modèle de notification</a></li>
        </ol>
    </section>

    @if(session()->has('created'))
        <div class="alert alert-success">
            {{session()->get('created')}}
        </div>
        {{session()->remove('created')}}
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Commission</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.notificationTemplate.push')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Titre</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Titre" required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="body">Description</label>
                                <textarea type="text" class="form-control" name="body" id="body" placeholder="Description" required></textarea>
                                <x-input-error :messages="$errors->get('body')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="body">Type</label>
                                <select name="to" class="form-control">
                                    <option value="{{\App\Enums\FirebaseTopic::ALL}}">{{\App\Enums\FirebaseTopic::ALL()->description}}</option>
                                    <option value="{{\App\Enums\FirebaseTopic::USERS}}">{{\App\Enums\FirebaseTopic::USERS()->description}}</option>
                                    <option value="{{\App\Enums\FirebaseTopic::SELLERS}}">{{\App\Enums\FirebaseTopic::SELLERS()->description}}</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary confirm">Confirmer</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <script>
        $(function () {
            $('.confirm').click(function (e){
                let response = confirm('Voulez vous Confirmer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
