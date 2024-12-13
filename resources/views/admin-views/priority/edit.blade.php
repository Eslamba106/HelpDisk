@extends('layouts.back-end.app')
@section('title', __('priority.prioritys'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/croppie.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img width="60" src="{{ asset('/public/assets/back-end/img/priority.jpg') }}" alt="">
                {{ __('priority.edit_priority') }}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        @can('edit_department')
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            {{ __('priority.edit_priority') }}
                        </div>
                        <div class="card-body" style="text-align: {{ Session::get('locale') === 'ar' ? 'right' : 'left' }};">
                            <form action="{{ route('priority.update', $priority->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <div class="form-group">
                                    <input type="hidden" id="id">
                                    <label class="title-color" for="name">{{ __('priority.priority_name') }}<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" name="name" class="form-control" value="{{ $priority->name }}"
                                        placeholder="{{ __('priority.enter_priority_name') }}">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="id">
                                    <label class="title-color" for="name">{{ __('priority.priority_time') }}<span
                                            class="text-danger">*</span> </label>
                                    <input type="number" name="time" class="form-control" value="{{ $priority->time }}"
                                        placeholder="{{ __('priority.enter_priority_time') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>


                                <div class="d-flex flex-wrap gap-2 justify-content-end">
                                    <button type="reset" class="btn btn-secondary">{{ __('general.reset') }}</button>
                                    <button type="submit" class="btn btn--primary">{{ __('general.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        @endcan

    @endsection
