@extends('layouts.app')

@section('title','panel - Ajouter promo code')
@section('content')
    <section class="content-header">
        <a href="{{route('dashboard.coupons.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i></a>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Acceuil</a></li>
            <li><a href="{{route('dashboard.coupons.index')}}">Promo code</a></li>
            <li><a class="active">Ajouter promo code</a></li>
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
                        <h3 class="box-title">Ajouter promo code</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="{{route('dashboard.coupons.store')}}" method="POST" role="form">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" id="code" name="code"
                                       placeholder="Code" required>
                                <x-input-error :messages="$errors->get('code')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description"
                                          placeholder="Description" required></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="value_type">Type de valeur</label>
                                <select class="form-control" name="value_type" id="value_type">
                                    <option value="{{\App\Enums\CouponValueType::STATIC}}">{{\App\Enums\CouponValueType::STATIC()->description}}</option>
                                    <option value="{{\App\Enums\CouponValueType::PERCENTAGE}}">{{\App\Enums\CouponValueType::PERCENTAGE()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('value_type')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="value">Valeur</label>
                                <input type="text" class="form-control" id="value" name="value"
                                          placeholder="Valeur" required>
                                <x-input-error :messages="$errors->get('value')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="{{\App\Enums\CouponType::CUSTOM}}">{{\App\Enums\CouponType::CUSTOM()->description}}</option>
                                    <option value="{{\App\Enums\CouponType::PERMANENT}}">{{\App\Enums\CouponType::PERMANENT()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="system_type">S'appliqué sur</label>
                                <select class="form-control" name="system_type" id="system_type">
                                    <option value="{{\App\Enums\CouponSystemType::ALL}}">{{\App\Enums\CouponSystemType::ALL()->description}}</option>
                                    <option value="{{\App\Enums\CouponSystemType::HOUSE}}">{{\App\Enums\CouponSystemType::HOUSE()->description}}</option>
                                    <option value="{{\App\Enums\CouponSystemType::VEHICLE}}">{{\App\Enums\CouponSystemType::VEHICLE()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('system_type')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="start_date">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                       placeholder="Date de début">
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="end_date">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                       placeholder="Date de fin">
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="usage_limit">Limite d'utilisation</label>
                                <input type="text" class="form-control" id="usage_limit" name="usage_limit"
                                       placeholder="Limite d'utilisation" required>
                                <x-input-error :messages="$errors->get('usage_limit')" class="mt-2"/>
                            </div>

                            <div class="form-group">
                                <label for="status">Statu</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="{{\App\Enums\CouponStatus::ACTIVE}}">{{\App\Enums\CouponStatus::ACTIVE()->description}}</option>
                                    <option value="{{\App\Enums\CouponStatus::INACTIVE}}">{{\App\Enums\CouponStatus::INACTIVE()->description}}</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2"/>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
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
            $('#type').click(function (e){
                let type = $('#type').val()
                let start_date = $('#start_date')
                let end_date = $('#end_date')

                if(type == 'permanent')
                {
                    start_date.prop('disabled',true)
                    end_date.prop('disabled',true)
                }

                if(type == 'custom')
                {
                    start_date.prop('disabled',false)
                    end_date.prop('disabled',false)
                }
            })
        })
    </script>
@endsection
