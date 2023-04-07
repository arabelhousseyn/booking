@extends('layouts.app')

@section('title','panel - Paramètres')
@section('content')
    <section class="content-header">
        <h1>
            Général
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Général</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Commission</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="commission">Commission</label>
                                <input type="text" class="form-control" value="{{$core->commission}}" name="commission" id="commission" placeholder="Commission %" required>
                                <x-input-error :messages="$errors->get('commission')" class="mt-2"/>
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
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Rayonnage</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="rayonnage">Rayonnage</label>
                                <input type="text" class="form-control" value="{{$core->KM}}" name="KM" id="rayonnage" placeholder="Rayonnage" required>
                                <x-input-error :messages="$errors->get('KM')" class="mt-2"/>
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

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Dahabia caution</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="dahabia_caution">Dahabia caution</label>
                                <input type="text" class="form-control" value="{{$core->dahabia_caution}}" name="dahabia_caution" id="dahabia_caution" placeholder="Dahabia caution" required>
                                <x-input-error :messages="$errors->get('dahabia_caution')" class="mt-2"/>
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

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Visa/master card caution</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="visa_masterCard_caution">Visa/master card caution</label>
                                <input type="text" class="form-control" value="{{$core->debit_card_caution}}" name="debit_card_caution" id="visa_masterCard_caution" placeholder="Visa/master card caution" required>
                                <x-input-error :messages="$errors->get('debit_card_caution')" class="mt-2"/>
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
