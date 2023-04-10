@extends('layouts.app')

@section('title','panel - Modifier promo code')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.coupons.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.coupons.index')}}">Promo code</a></li>
            <li><a class="active">Modifier promo code</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Modifier promo code</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.coupons.update',$coupon->id)}}" method="POST" role="form">
                        @method('PUT')
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" id="code" value="{{$coupon->code}}" name="code"
                                       placeholder="Code">
                                <x-input-error :messages="$errors->get('code')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Description">{{$coupon->description}}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="value_type">Type de valeur</label>
                                <select class="form-control" name="value_type" id="value_type">
                                    <option value="{{\App\Enums\CouponValueType::STATIC}}" @selected(\App\Enums\CouponValueType::STATIC == $coupon->value_type)>{{\App\Enums\CouponValueType::STATIC()->description}}</option>
                                    <option value="{{\App\Enums\CouponValueType::PERCENTAGE}}" @selected(\App\Enums\CouponValueType::PERCENTAGE == $coupon->value_type)>{{\App\Enums\CouponValueType::PERCENTAGE()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('value_type')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="value">Valeur</label>
                                <input type="text" class="form-control" id="value" value="{{$coupon->value}}" name="value"
                                       placeholder="Valeur">
                                <x-input-error :messages="$errors->get('value')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="{{\App\Enums\CouponType::CUSTOM}}" @selected(\App\Enums\CouponType::CUSTOM == $coupon->type)>{{\App\Enums\CouponType::CUSTOM()->description}}</option>
                                    <option value="{{\App\Enums\CouponType::PERMANENT}}" @selected(\App\Enums\CouponType::PERMANENT == $coupon->type)>{{\App\Enums\CouponType::PERMANENT()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="system_type">S'appliqué sur</label>
                                <select class="form-control" name="system_type" id="system_type">
                                    <option value="{{\App\Enums\CouponSystemType::ALL}}" @selected(\App\Enums\CouponSystemType::ALL == $coupon->system_type)>{{\App\Enums\CouponSystemType::ALL()->description}}</option>
                                    <option value="{{\App\Enums\CouponSystemType::HOUSE}}" @selected(\App\Enums\CouponSystemType::HOUSE == $coupon->system_type)>{{\App\Enums\CouponSystemType::HOUSE()->description}}</option>
                                    <option value="{{\App\Enums\CouponSystemType::VEHICLE}}" @selected(\App\Enums\CouponSystemType::VEHICLE == $coupon->system_type)>{{\App\Enums\CouponSystemType::VEHICLE()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('system_type')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="start_date">Date de début</label>
                                <input type="date" class="form-control" id="start_date" value="{{$coupon->start_date}}" name="start_date"
                                       placeholder="Date de début">
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="end_date">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" value="{{$coupon->end_date}}" name="end_date"
                                       placeholder="Date de fin">
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="usage_limit">Limite d'utilisation</label>
                                <input type="text" class="form-control" id="usage_limit" value="{{$coupon->usage_limit}}" name="usage_limit"
                                       placeholder="Limite d'utilisation">
                                <x-input-error :messages="$errors->get('usage_limit')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="status">Statu</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="{{\App\Enums\CouponStatus::ACTIVE}}" @selected(\App\Enums\CouponStatus::ACTIVE == $coupon->status)>{{\App\Enums\CouponStatus::ACTIVE()->description}}</option>
                                    <option value="{{\App\Enums\CouponStatus::INACTIVE}}" @selected(\App\Enums\CouponStatus::INACTIVE == $coupon->status)>{{\App\Enums\CouponStatus::INACTIVE()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2"/>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Modifier</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>

    <script>
        $(function () {

            let type = $('#type').val()
            let start_date = $('#start_date')
            let end_date = $('#end_date')

            if(type == 'permanent')
            {
                start_date.prop('readonly',true)
                end_date.prop('readonly',true)

                start_date.prop('value',null)
                end_date.prop('value',null)
            }

            if(type == 'custom')
            {
                start_date.prop('readonly',false)
                end_date.prop('readonly',false)
            }

            $('#type').click(function (e){
                let type = $('#type').val()
                let start_date = $('#start_date')
                let end_date = $('#end_date')

                if(type == 'permanent')
                {
                    start_date.prop('readonly',true)
                    end_date.prop('readonly',true)

                    start_date.prop('value',null)
                    end_date.prop('value',null)
                }

                if(type == 'custom')
                {
                    start_date.prop('readonly',false)
                    end_date.prop('readonly',false)
                }
            })
        })
    </script>
@endsection
