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

    @if(session()->has('created'))
        <div class="alert alert-success">
            {{session()->get('created')}}
        </div>
        @php
            session()->remove('created')
        @endphp
    @endif


    @if(session()->has('paymentError'))
        <div class="alert alert-danger">
            {{session()->get('paymentError')}}
        </div>
        @php
            session()->remove('paymentError')
        @endphp
    @endif

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
                                <th>Type</th>
                                <th>Paiement</th>
                                <th>P.originale</th>
                                <th>P.totale</th>
                                <th>Commission</th>
                                <th>caution</th>
                                <th>Remboursement</th>
                                <th>Date de debut</th>
                                <th>Date de fin</th>
                                <th>Promo code</th>
                                <th>Statu de paiement</th>
                                <th>Statu</th>
                                <th>Note</th>
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
                                    <td>
                                        {{$booking->bookable_type->description}}
                                        @if($booking->bookable_type == \App\Enums\ModelType::VEHICLE)
                                            <a href="{{route('dashboard.bookings.state',$booking->id)}}"
                                               class="btn btn-success">
                                                État du véhicule
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{$booking->payment_type}}</td>
                                    <td>{{(new NumberFormatter('ar_DZ',NumberFormatter::CURRENCY))->formatCurrency($booking->original_price,'DZD')}}</td>
                                    <td>{{(new NumberFormatter('ar_DZ',NumberFormatter::CURRENCY))->formatCurrency($booking->calculated_price,'DZD')}}</td>
                                    <td>{{$booking->commission}} %</td>
                                    <td>{{(new NumberFormatter('ar_DZ',NumberFormatter::CURRENCY))->formatCurrency($booking->caution,'DZD')}}</td>
                                    <td>{{(new NumberFormatter('ar_DZ',NumberFormatter::CURRENCY))->formatCurrency($booking?->refund,'DZD')}}</td>
                                    <td>{{$booking->start_date}}</td>
                                    <td>{{$booking->end_date}}</td>
                                    <td>{{$booking->coupon_code}}</td>
                                    <td>{{\App\Enums\PaymentStatus::fromValue($booking->payment_status)->description}}</td>
                                    <td>{{\App\Enums\BookingStatus::fromValue($booking->status)->description}}</td>
                                    <td>
                                        <a href="{{route('dashboard.bookings.show',$booking->id)}}"
                                           class="btn btn-success"><i
                                                class="fa fa-image"></i></a>
                                    </td>
                                    <td>{{$booking->created_at?->format('Y-m-d H:i:s')}}</td>
                                    <td style="display: flex;flex-direction: row;">
                                        @if($booking->status == \App\Enums\BookingStatus::PENDING)

                                            <form action="{{route('dashboard.bookings.accept',$booking->id)}}"
                                                  method="post">
                                                @csrf
                                                <button type="submit" id="accept-booking" value="{{$booking->id}}"
                                                        class="btn btn-success"><i class="fa fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{route('dashboard.bookings.decline',$booking->id)}}"
                                                  method="post">
                                                @csrf
                                                <button type="submit" id="decline-booking" value="{{$booking->id}}"
                                                        class="btn btn-danger"><i class="fa fa-ban"></i>
                                                </button>
                                            </form>

                                            <form action="{{route('dashboard.bookings.destroy',$booking->id)}}"
                                                  method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" id="delete-booking" value="{{$booking->id}}"
                                                        class="btn btn-danger"><i class="fa fa-minus"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($booking->status == \App\Enums\BookingStatus::DECLINED)
                                            <a href="{{route('dashboard.bookings.edit',$booking->id)}}"
                                               class="btn btn-success"><i
                                                    class="fa fa-edit"></i></a>

                                            <form action="{{route('dashboard.bookings.destroy',$booking->id)}}"
                                                  method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" id="delete-booking" value="{{$booking->id}}"
                                                        class="btn btn-danger"><i class="fa fa-minus"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if($booking->status == \App\Enums\BookingStatus::COMPLETED)

                                            @if(is_null($booking->refund))
                                                <a href="{{route('dashboard.bookings.view-refund',$booking->id)}}"
                                                   class="btn btn-success"><i
                                                        class="fa fa-dollar"></i></a>
                                            @endif

                                            <form action="{{route('dashboard.bookings.destroy',$booking->id)}}"
                                                  method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" id="delete-booking" value="{{$booking->id}}"
                                                        class="btn btn-danger"><i class="fa fa-minus"></i>
                                                </button>
                                            </form>
                                        @endif
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
                'order': [[17, 'asc']],
                'info': true,
                'autoWidth': false
            })

            $('#delete-booking').click(function (e) {
                let response = confirm('Voulez vous supprimer ?')
                if (!response) {
                    e.preventDefault()
                }
            })

            $('#accept-booking').click(function (e) {
                let response = confirm('Voulez vous Accepter ?')
                if (!response) {
                    e.preventDefault()
                }
            })

            $('#decline-booking').click(function (e) {
                let response = confirm('Voulez vous Refuser ?')
                if (!response) {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
