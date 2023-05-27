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

    @if(session()->has('created'))
        <div class="alert alert-success">
            {{session()->get('created')}}
        </div>
        @php
            session()->remove('created')
        @endphp
    @endif

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
                        <h3 class="box-title">Véhicule dahabia caution</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="vehicle_dahabia_caution">Véhicule dahabia caution</label>
                                <input type="text" class="form-control" value="{{$core->vehicle_dahabia_caution}}" name="vehicle_dahabia_caution" id="vehicle_dahabia_caution" placeholder="Véhicule dahabia caution" required>
                                <x-input-error :messages="$errors->get('vehicle_dahabia_caution')" class="mt-2"/>
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
                        <h3 class="box-title">Véhicule visa/master card caution</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="vehicle_visa_masterCard_caution">Véhicule visa/master card caution</label>
                                <input type="text" class="form-control" value="{{$core->vehicle_debit_card_caution}}" name="vehicle_debit_card_caution" id="vehicle_visa_masterCard_caution" placeholder="Véhicule visa/master card caution" required>
                                <x-input-error :messages="$errors->get('vehicle_debit_card_caution')" class="mt-2"/>
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
                        <h3 class="box-title">Maison dahabia caution</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="house_dahabia_caution">Maison dahabia caution</label>
                                <input type="text" class="form-control" value="{{$core->house_dahabia_caution}}" name="house_dahabia_caution" id="house_dahabia_caution" placeholder="Maison dahabia caution" required>
                                <x-input-error :messages="$errors->get('house_dahabia_caution')" class="mt-2"/>
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
                        <h3 class="box-title">Maison visa/master card caution</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{route('dashboard.settings.core')}}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="house_visa_masterCard_caution">Visa/master card caution</label>
                                <input type="text" class="form-control" value="{{$core->house_debit_card_caution}}" name="house_debit_card_caution" id="house_visa_masterCard_caution" placeholder="Maison visa/master card caution" required>
                                <x-input-error :messages="$errors->get('house_debit_card_caution')" class="mt-2"/>
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
