@extends('layouts.app')

@section('title','panel - Véhicules')
@section('content')
    <section class="content-header">
        <h1>
            Véhicules
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Véhicules</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Véhicules</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="vehicles" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Propriétaire</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Nombre de places</th>
                                <th>Motorisation</th>
                                <th>Boîte de vitesses</th>
                                <th>Est rempli</th>
                                <th>Paiements acceptés</th>
                                <th>Documents</th>
                                <th>Notation</th>
                                <th>Statu</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vehicles as $vehicle)
                                <tr>
                                    <td>{{$vehicle->seller->first_name}} {{$vehicle->seller->last_name}}</td>
                                    <td>{{$vehicle->title}}</td>
                                    <td>{{$vehicle->description}}</td>
                                    <td>{{$vehicle->price}} DZD</td>
                                    <td>{{$vehicle->places}}</td>
                                    <td>{{\App\Enums\Motorisation::fromValue($vehicle->motorisation)->description}}</td>
                                    <td>{{\App\Enums\GearBox::fromValue($vehicle->gearbox)->description}}</td>
                                    <td>
                                        @if($vehicle->is_full)
                                            <div class="alert alert-success">Oui</div>
                                        @else
                                            <div class="alert alert-success">Non</div>
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            <li>
                                                @if(json_decode($vehicle->payments_accepted)->dahabia)
                                                    Dahabia : <div class="alert alert-success">Oui</div>
                                                @else
                                                    Dahabia : <div class="alert alert-success">Non</div>
                                                @endif
                                            </li>
                                            <li>
                                                @if(json_decode($vehicle->payments_accepted)->debit_card)
                                                    Visa/master card : <div class="alert alert-success">Oui</div>
                                                @else
                                                    Visa/master card : <div class="alert alert-success">Non</div>
                                                @endif
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{route('dashboard.vehicles.show',$vehicle->id)}}" class="btn btn-success"><i class="fa fa-file"></i></a>
                                    </td>
                                    <td>
                                        <div class="ratings">
                                            @for($i=0;$i<$vehicle->reviews->avg('rating');$i++)
                                                <i class="fa fa-star rating-color"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{\App\Enums\Status::fromValue($vehicle->status)->description}}</td>
                                    <td>{{$vehicle->created_at->format('Y-m-d H:i:s')}}</td>
                                    <td style="display: flex;flex-direction: row;">
                                        <a href="{{route('dashboard.vehicles.edit',$vehicle->id)}}" class="btn btn-success"><i
                                                class="fa fa-edit"></i></a>

                                        @if($vehicle->status == \App\Enums\Status::PENDING)
                                            <form action="{{route('dashboard.vehicles.publish',$vehicle->id)}}" method="post">
                                                @csrf
                                                <button type="submit" id="publish-vehicle" value="{{$vehicle->id}}" class="btn btn-success"><i class="fa fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{route('dashboard.vehicles.decline',$vehicle->id)}}" method="post">
                                                @csrf
                                                <button type="submit" id="decline-vehicle" value="{{$vehicle->id}}" class="btn btn-danger"><i class="fa fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($vehicle->status != \App\Enums\Status::BOOKED)
                                            <form action="{{route('dashboard.vehicles.destroy',$vehicle->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" id="delete-vehicle" value="{{$vehicle->id}}" class="btn btn-danger"><i class="fa fa-minus"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;">
                            {{$vehicles->links()}}
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
            $('#vehicles').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'sorting': false,
                'order': [[12, 'desc']],
                'info': true,
                'autoWidth': false
            })

            $('#delete-vehicle').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })

            $('#publish-vehicle').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })

            $('#decline-vehicle').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
