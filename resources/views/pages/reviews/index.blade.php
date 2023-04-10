@extends('layouts.app')

@section('title','panel - Commentaires')
@section('content')
    <section class="content-header">
        <h1>
            Commentaires
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Commentaires</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Commentaires</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="reviews" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Reviwer</th>
                                <th>Propriété</th>
                                <th>Type propriété</th>
                                <th>Notation</th>
                                <th>Date de review</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reviews as $review)
                                <tr>
                                    <td>{{$review->user->first_name}} {{$review->user->last_name}}</td>
                                    <td>{{$review->reviewable->title}}</td>
                                    <td>{{\App\Enums\ModelType::fromValue($review->reviewable_type)->description}}</td>
                                    <td>
                                        <div class="ratings">
                                            @for($i=0;$i<$review->rating;$i++)
                                                <i class="fa fa-star rating-color"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{$review->created_at->format('Y-m-d H:i:s')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;">
                            {{$reviews->links()}}
                        </div>
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
            $('#reviews').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'sorting': false,
                'order': [[4, 'desc']],
                'info': true,
                'autoWidth': false
            })
        })
    </script>
@endsection
