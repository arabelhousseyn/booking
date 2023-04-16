@extends('layouts.app')

@section('title','panel - Réservations')
@section('content')
    <section class="content-header">
        <h1>
            Réservations
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Réservations</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Réservations</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="bookings" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Utilisateur</th>
                                <th>Partenaire</th>
                                <th>Réservable</th>
                                <th>Type de réservable</th>
                                <th>Paiement</th>
                                <th>Prix net</th>
                                <th>Prix total</th>
                                <th>Commission</th>
                                <th>A caution</th>
                                <th>Date de debut</th>
                                <th>Date de fin</th>
                                <th>Promo code</th>
                                <th>Statu</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{$booking->reference}}</td>
                                    <td>{{$booking->user->first_name}} {{$booking->user->last_name}}</td>
                                    <td>{{$booking->seller->first_name}} {{$booking->seller->last_name}}</td>
                                    <td>{{$booking->bookable->title}}</td>
                                    <td>{{$booking->bookable_type->description}}</td>
                                    <td>{{$booking->payment_type}}</td>
                                    <td>{{(new NumberFormatter('ar_DZ',NumberFormatter::CURRENCY))->formatCurrency($booking->net_price,'DZD')}}</td>
                                    <td>{{(new NumberFormatter('ar_DZ',NumberFormatter::CURRENCY))->formatCurrency($booking->total_price,'DZDs')}}</td>
                                    <td>{{$booking->commission}} %</td>
                                    <td>
                                        @if($booking->has_caution)
                                            <div class="alert alert-success">Oui</div>
                                        @else
                                            <div class="alert alert-danger">Non</div>
                                        @endif
                                    </td>
                                    <td>{{$booking->start_date}}</td>
                                    <td>{{$booking->end_date}}</td>
                                    <td>{{$booking->coupon_code}}</td>
                                    <td>{{\App\Enums\BookingStatus::fromValue($booking->status)->description}}</td>
                                    <td>{{$booking->created_at?->format('Y-m-d H:i:s')}}</td>
                                    <td>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="float: right;">
                            {{$bookings->links()}}
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
            $('#bookings').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'sorting': false,
                'order': [[14, 'asc']],
                'info': true,
                'autoWidth': false
            })

            $('#delete-booking').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })

            $('#accept-booking').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })

            $('#decline-booking').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
