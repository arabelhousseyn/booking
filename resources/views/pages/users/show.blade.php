@extends('layouts.app')

@section('title','panel - Documents')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.users.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <h1>
            Documents
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-users"></i> Utilisateurs</a></li>
            <li><a class="active">Documents</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Documents</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="users" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->documents as $document)
                                <tr>
                                    <td><b>{{$document->document_type->description}}</b></td>
                                    <td>
                                        <img src="{{$document->document_url}}" width="300" height="300">
                                    </td>
                                    <td>
                                        @switch($document->status)
                                            @case(\App\Enums\UserDocumentStatus::PENDING)  <span
                                                class="alert alert-warning">En attente</span> @break
                                            @case(\App\Enums\UserDocumentStatus::CONFIRMED)  <span
                                                class="alert alert-success">Confirmé</span> @break
                                            @case(\App\Enums\UserDocumentStatus::DECLINED) <span
                                                class="alert alert-danger">Refuser</span> @break
                                        @endswitch
                                    </td>
                                    <td style="display: flex;flex-direction: row;">
                                        @if(\App\Enums\UserDocumentStatus::PENDING == $document->status)
                                            <form action="{{route('dashboard.users.documents',[$user->id,$document->id])}}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{\App\Enums\UserDocumentStatus::CONFIRMED}}" name="status">
                                                <button class="btn btn-success confirm_document">Accepter</button>
                                            </form>

                                            <form action="{{route('dashboard.users.documents',[$user->id,$document->id])}}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{\App\Enums\UserDocumentStatus::DECLINED}}" name="status">
                                                <button class="btn btn-danger confirm_document">Refuser</button>
                                            </form>
                                        @endif
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

            $('.confirm_document').click(function (e) {
                let response = confirm('Voulez vous Confirmer ?')
                if (!response) {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
