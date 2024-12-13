@extends('layouts.back-end.app')

@section('title', __('dashboard.dashboard'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header pb-0 mb-0 border-0">
                <div class="flex-between align-items-center">
                    <div>
                        <h1 class="page-header-title" style="text-align: {{Session::get('locale') == "ar" ? 'right' : 'left'}};">{{__('dashboard.dashboard')}}</h1>
                        <p>{{ __('dashboard.welcome_message')}}.</p>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Business Analytics -->
            <div class="card mb-2 remove-card-shadow">
                <div class="card-body">
                    {{-- <div class="row flex-between align-items-center g-2 mb-3">
                        <div class="col-sm-6">
                            <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                                <img src="{{asset('/public/assets/back-end/img/business_analytics.png')}}" alt="">{{__('business_analytics')}}</h4>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-sm-end">
                            <select class="custom-select w-auto" name="statistics_type"
                                    onchange="order_stats_update(this.value)">
                                <option
                                    value="overall" {{session()->has('statistics_type') && session('statistics_type') == 'overall'?'selected':''}}>
                                    {{ __('overall_statistics')}}
                                </option>
                                <option
                                    value="today" {{session()->has('statistics_type') && session('statistics_type') == 'today'?'selected':''}}>
                                    {{ __("todays_Statistics")}}
                                </option>
                                <option
                                    value="this_month" {{session()->has('statistics_type') && session('statistics_type') == 'this_month'?'selected':''}}>
                                    {{ __("this_Months_Statistics")}}
                                </option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="row g-2" id="order_stats">

                        <?php $data =null;
                            $data['customer'] = "Cu";
                            $data['store'] = "St";
                            $data['product'] = "Pr";
                            $data['order'] = "Or";
                            $data['brand'] = "Br"; 

                        ?>
                        @include('admin-views.partials._dashboard-order-stats',['data'=>$data])
                    </div>
                </div>
            </div>
            <!-- End Business Analytics -->


            <!-- Admin Wallet -->
            {{-- <div class="card mb-3 remove-card-shadow">
                <div class="card-body">
                    <h4 class="d-flex align-items-center text-capitalize gap-10 mb-3">
                        <img width="20" class="mb-1" src="{{asset('/public/assets/back-end/img/admin-wallet.png')}}" alt="">
                        {{__('admin_wallet')}}
                    </h4>

                    <div class="row g-2" id="order_stats">
                        @include('admin-views.partials._dashboard-wallet-stats',['data'=>$data])
                    </div>
                </div>
            </div> --}}
            <!-- End Admin Wallet -->

@endsection
