@extends('layouts.app')

@section('title','panel - dashboard')
@section('javascript')
    @section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Véhicules</span>
                            <span class="info-box-number">{{$vehicles_count}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion-ios-home"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total maison</span>
                            <span class="info-box-number">{{$houses_count}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Véhicules en attente</span>
                            <span class="info-box-number">{{$pending_vehicles_count}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion-ios-home"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total maison en attente</span>
                            <span class="info-box-number">{{$pending_houses_count}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            {{ $chart1->options['chart_title'] }}
                        </div>
                        <div class="card-body">
                            {!! $chart1->renderHtml() !!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            {{ $chart2->options['chart_title'] }}
                        </div>
                        <div class="card-body">
                            {!! $chart2->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
        {!! $chart1->renderChartJsLibrary() !!}
        {!! $chart1->renderJs() !!}

        {!! $chart2->renderChartJsLibrary() !!}
        {!! $chart2->renderJs() !!}
    @endsection
