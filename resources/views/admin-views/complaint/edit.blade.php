@extends('layouts.back-end.app')
@section('title', __('complaint.complaints'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img width="60" src="{{asset('/public/assets/back-end/img/complaints.png')}}" alt="">
            {{__('complaint.edit_complaint')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    {{ __('complaint.edit_complaint')}}
                </div> 
                <div class="card-body" style="text-align: {{ Session::get('locale') === "ar" ? 'right' : 'left'}};">
                    <form action="{{route('complaint.update' , $complaint->id)}}" method="post">
                        @csrf
                        @method('patch')
                        <div class="form-group" >
                            <input type="hidden" id="id">
                            <label class="title-color" for="name">{{ __('complaint.complaint_name')}}<span class="text-danger">*</span>  </label>
                            <input type="text" name="name" class="form-control" value="{{ $complaint->name }}"  
                                   placeholder="{{__('complaint.enter_complaint_name')}}" >
                        </div>
                        <div class="form-group">
                            <label for="worker" class="title-color">{{ __('department.department') }}</label>
                            <div class="d-flex align-items-center">
                                <select class="js-select2-custom form-control me-2" name="department_id">
                                    @forelse ($departments as $department)
                                        <option value="{{ $department->id }}" @if ($complaint->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <input type="hidden" id="id">
                            <label class="title-color" for="name">{{ __('complaint.complaint_time')}}<span class="text-danger">*</span>  </label>
                            <textarea name="description" class="form-control"  id="" cols="30" rows="3">{{ $complaint->description }}</textarea>
                            {{-- <input type="text" name="description" class="form-control" value="{{ $complaint->description }}" 
                                   placeholder="{{__('complaint.enter_complaint_description')}}" > --}}
                                    
                        </div>
                        <div class="form-group">
                            <label for="worker" class="title-color">{{ __('priority.priorities') }}</label>
                            <div class="d-flex align-items-center">
                                <select class="js-select2-custom form-control me-2" name="priorirty_id">
                                    @forelse ($priorirties as $priorirty)
                                        <option value="{{ $priorirty->id }}" @if ($complaint->priorirty_id == $priorirty->id) selected @endif>{{ $priorirty->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <button type="reset" class="btn btn-secondary">{{__('general.reset')}}</button>
                            <button type="submit" class="btn btn--primary">{{__('general.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>

    
@endsection