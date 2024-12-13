@extends('layouts.back-end.app')
@section('title', __('department.departments'))
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
            <img width="60" src="{{asset('/public/assets/back-end/img/departments.png')}}" alt="">
            {{__('department.departments')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    {{ __('department.add_new_department')}}
                </div> 
                <div class="card-body" style="text-align: {{ Session::get('locale') === "ar" ? 'right' : 'left'}};">
                    <form action="{{route('department.store')}}" method="post">
                        @csrf

                        <div class="form-group" >
                            <input type="hidden" id="id">
                            <label class="title-color" for="name">{{ __('department.department_name')}}<span class="text-danger">*</span>  </label>
                            <input type="text" name="name" class="form-control"  
                                   placeholder="{{__('department.enter_department_name')}}" >
                        </div>
                        <div class="form-group">
                            <label class="title-color" for="time">
                                {{ __('department.department_time') }}
                                {{-- <span class="text-danger">*</span> --}}
                            </label>
                            <div class="input-group">
                                <input type="text" name="description" id="description" class="form-control" 
                                       placeholder="{{ __('department.enter_department_time') }}">
                                 
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

        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4">
                    <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 d-flex align-items-center gap-2">{{ __('department.department_list')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12"> </span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{ __('department.search_by_department_name') }}" aria-label="Search" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn--primary">{{ __('general.search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                </div>
                <div style="text-align: {{Session::get('locale') === "ar" ? 'right' : 'left'}};">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ __('general.sl')}}</th>
                                    <th class="text-center">{{ __('department.department_name')}} </th>
                                    <th class="text-center">{{ __('department.department_time')}} </th>
                                    <th class="text-center">{{ __('general.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $key => $department)
                                <tr>
                                    <td>{{$departments->firstItem()+$key}}</td>
                                    <td class="text-center">{{ ($department->name)}}</td>
                                    <td class="text-center">{{ $department->description }} </td>
                                    <td>
                                       <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn"
                                                title="{{ __('general.edit')}}"
                                                href="{{ route('department.edit' , $department->id) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete square-btn"
                                                title="{{ __('general.delete')}}"
                                                id="{{ $department['id'] }}">
                                                <i class="tio-delete"></i>
                                            </a>
                                       </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <div class="d-flex justify-content-lg-end">
                        <!-- Pagination -->
                        {!! $departments->links() !!}
                    </div>
                </div>

                @if(count($departments)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                        <p class="mb-0">{{ __('general.no_data_to_show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

    <script>
        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: "{{__('general.are_you_sure_delete_this')}}",
                text: "{{__('general.you_will_not_be_able_to_revert_this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{__('general.yes_delete_it')}}!',
                cancelButtonText: '{{ __("general.cancel") }}',
                type: 'warning',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('department.delete') }}",
                        method: 'get',
                        data: {id: id},
                        success: function () {
                            toastr.success('{{__('department.deleted_successfully')}}');
                            location.reload();
                        }
                    });
                }
            })
        });



         // Call the dataTables jQuery plugin


    </script>
@endpush