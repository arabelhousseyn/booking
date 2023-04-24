@extends('layouts.app')

@section('title','panel - Maisons')
@section('content')
    <section class="content-header">
        <h1>
            Maisons
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Maisons</a></li>
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
                        <h3 class="box-title">Maisons</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="houses" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Propriétaire</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Nbr de chambre</th>
                                <th>A le wifi</th>
                                <th>Parking</th>
                                <th>Notation</th>
                                <th>Statu</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($houses as $house)
                                <tr>
                                    <td>{{$house->seller->first_name}} {{$house->seller->last_name}}</td>
                                    <td>{{$house->title}}</td>
                                    <td>{{$house->description}}</td>
                                    <td>{{(new NumberFormatter('ar_DZ',NumberFormatter::CURRENCY))->formatCurrency($house->price,'DZD')}}</td>
                                    <td>{{$house->rooms}}</td>
                                    <td>
                                        @if($house->has_wifi)
                                            <div class="alert alert-success">Oui</div>
                                        @else
                                            <div class="alert alert-success">Non</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($house->parking_station)
                                            <div class="alert alert-success">Oui</div>
                                        @else
                                            <div class="alert alert-success">Non</div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="ratings">
                                            @for($i=0;$i<$house->reviews->avg('rating');$i++)
                                                <i class="fa fa-star rating-color"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{\App\Enums\Status::fromValue($house->status)->description}}</td>
                                    <td>{{$house->created_at->format('Y-m-d H:i:s')}}</td>
                                    <td style="display: flex;flex-direction: row;">

                                        @if($house->status != \App\Enums\Status::BOOKED)
                                            <a href="{{route('dashboard.houses.edit',$house->id)}}" class="btn btn-success"><i
                                                    class="fa fa-edit"></i></a>

                                            <form action="{{route('dashboard.houses.destroy',$house->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" id="delete-house" value="{{$house->id}}" class="btn btn-danger"><i class="fa fa-minus"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($house->status == \App\Enums\Status::PENDING)
                                            <form action="{{route('dashboard.houses.publish',$house->id)}}" method="post">
                                                @csrf
                                                <button type="submit" id="publish-house" value="{{$house->id}}" class="btn btn-success"><i class="fa fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{route('dashboard.houses.decline',$house->id)}}" method="post">
                                                @csrf
                                                <button type="submit" id="decline-house" value="{{$house->id}}" class="btn btn-danger"><i class="fa fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;">
                            {{$houses->links()}}
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
            $('#houses').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'sorting': false,
                'order': [[9, 'desc']],
                'info': true,
                'autoWidth': false
            })

            $('#delete-house').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })

            $('#publish-house').click(function (e){
                let response = confirm('Voulez vous accepter ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })

            $('#decline-house').click(function (e){
                let response = confirm('Voulez vous refuser ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
