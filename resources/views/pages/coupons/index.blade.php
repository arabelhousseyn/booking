@extends('layouts.app')

@section('title','panel - Promo code')
@section('content')
    <section class="content-header">
        <h1>
            Promo code
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a class="active">Promo code</a></li>
        </ol>
    </section>

    @if(session()->has('created'))
        <div class="alert alert-success">
            {{session()->get('created')}}
        </div>
        {{session()->remove('created')}}
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Promo code</h3>
                        <a href="{{route('dashboard.coupons.create')}}" class="btn btn-primary" style="float: right;"><i
                                class="fa fa-plus"></i>
                            Ajouter</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="coupons" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Type de valeur</th>
                                <th>Valeur</th>
                                <th>Type</th>
                                <th>S'appliqué sur</th>
                                <th>Date de debut</th>
                                <th>Date de fin</th>
                                <th>Limite d'utilisation</th>
                                <th>Statu</th>
                                <th>Date de creation</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>{{$coupon->code}}</td>
                                    <td>{{$coupon->description}}</td>
                                    <td>{{\App\Enums\CouponValueType::fromValue($coupon->value_type)->description}}</td>
                                    <td>{{$coupon->value}}</td>
                                    <td>{{\App\Enums\CouponType::fromValue($coupon->type)->description}}</td>
                                    <td>{{\App\Enums\CouponSystemType::fromValue($coupon->system_type)->description}}</td>
                                    <td>{{$coupon->start_date}}</td>
                                    <td>{{$coupon->end_date}}</td>
                                    <td>{{$coupon->usage_limit}}</td>
                                    <td>{{\App\Enums\CouponStatus::fromValue($coupon->status)->description}}</td>
                                    <td>{{$coupon->created_at->format('Y-m-d H:i:s')}}</td>
                                    <td style="display: flex;flex-direction: row;">
                                        <a href="{{route('dashboard.coupons.edit',$coupon->id)}}" class="btn btn-success"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{route('dashboard.coupons.destroy',$coupon->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" id="delete-coupon" value="{{$coupon->id}}" class="btn btn-danger"><i class="fa fa-minus"></i>
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
            $('#coupons').DataTable({
                'paging': false,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'sorting': false,
                'order': [[10, 'desc']],
                'info': true,
                'autoWidth': false
            })

            $('#delete-coupon').click(function (e){
                let response = confirm('Voulez vous supprimer ?')
                if(!response)
                {
                    e.preventDefault()
                }
            })
        })
    </script>
@endsection
