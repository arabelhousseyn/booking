@extends('layouts.app')

@section('title','panel - Raisons de réclamation')
@section('content')
    <section class="content-header">
        <h1>
            Raisons de réclamation
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Raisons de réclamation</a></li>
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Raisons de réclamation</h3>
                        <a href="{{route('dashboard.reasons.create')}}" class="btn btn-primary" style="float: right;"><i
                                class="fa fa-plus"></i>
                            Ajouter</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="reasons" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reasons as $reason)
                                <tr>
                                    <td>{{$reason->description}}</td>
                                    <td>{{$reason->type->description}}</td>
                                    <td style="display: flex;flex-direction: row;">
                                        <a href="{{route('dashboard.reasons.edit',$reason->id)}}" class="btn btn-success"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{route('dashboard.reasons.destroy',$reason->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" id="delete-reason" value="{{$reason->id}}" class="btn btn-danger"><i class="fa fa-minus"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <script>
        $(function () {
            $('#delete-reason').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
