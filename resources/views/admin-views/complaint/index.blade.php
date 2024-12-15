@extends('layouts.back-end.app')
@section('title', __('complaint.complaints'))
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
                <img width="60" src="{{ asset('/public/assets/back-end/img/complaint.jpg') }}" alt="">
                {{ __('complaint.complaints') }}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            @can('add_new_complaint')
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            {{ __('complaint.add_new_complaint') }}
                        </div>
                        <div class="card-body" style="text-align: {{ Session::get('locale') === 'ar' ? 'right' : 'left' }};">
                            <form action="{{ route('complaint.store') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <input type="hidden" id="id">
                                    <label class="title-color" for="name">{{ __('complaint.complaint_name') }}<span
                                            class="text-danger">*</span> </label>
                                            <div class="d-flex align-items-center">
                                                <select class="js-select2-custom form-control me-2" name="complaint_management_id">
                                                    @forelse ($complaint_managements as $complaint_management)
                                                        <option value="{{ $complaint_management->id }}">{{ $complaint_management->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                </div>
                                <div class="form-group">
                                    <label for="worker" class="title-color">{{ __('department.department') }}</label>
                                    <div class="d-flex align-items-center">
                                        <select class="js-select2-custom form-control me-2" name="department_id">
                                            @forelse ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="title-color" for="time">
                                        {{ __('complaint.complaint_time') }}
                                    </label>
                                    <div class="input-group">
                                        <textarea name="description" id="" cols="30" rows="3" class="form-control"></textarea>
                                        {{-- <input type="text" name="description" id="description" class="form-control" 
                                       placeholder="{{ __('complaint.enter_complaint_time') }}"> --}}

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="worker" class="title-color">{{ __('priority.priorities') }}</label>
                                    <div class="d-flex align-items-center">
                                        <select class="js-select2-custom form-control me-2" name="priorirty_id">
                                            @forelse ($priorirties as $priorirty)
                                                <option value="{{ $priorirty->id }}">{{ $priorirty->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
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
            @endcan
            @can('all_complaints')
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        {{ __('general.search') }}
                    </div>
                    <div class="card-body" style="text-align: {{ Session::get('locale') === 'ar' ? 'right' : 'left' }};">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group input-group-custom input-group-merge">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="{{ __('complaint.search_by_complaint_name') }}"
                                    aria-label="Search" value="{{ $search }}" required>
                                <button type="submit"
                                    class="btn btn-primary">{{ __('general.search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ __('general.filter') }}
                    </div>
                    <form action="{{ url()->current() }}" method="GET">
                    <div class="card-body" style="text-align: {{ Session::get('locale') === 'ar' ? 'right' : 'left' }};">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="name" class="title-color">{{ __('general.from') }}</label>
                                        <input type="date"  class="form-control" name="from">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="name" class="title-color">{{ __('general.to') }}</label>
                                        <input type="date"  class="form-control" name="to">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-4 col-xl-3 mt-4">
                                    <label for=""></label>
                                    <button type="submit" value="filter" name="bulk_action_btn" class="btn btn-primary px-5">{{ __('general.filter') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="card">
                <div class="px-3 py-4">
                    <div class="row align-items-center">
                         
                        <div class="col-sm-8 col-md-6 col-lg-12">
                            <!-- Search -->
                             
                            <!-- End Search -->
                        </div>
                        <!-- Search --> 
                    </div>
                    


                </div>     
            </div> --}}
                <form action="{{ url()->current() }}" method="GET" class="col-md-12">

                    {{-- <div > --}}

                        <div class="card">
                            <div class="px-3 py-4">
                                <div class="row align-items-center">
                                    <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                        <h5 class="mb-0 d-flex align-items-center gap-2">{{ __('complaint.complaint_list') }}
                                            <span class="badge badge-soft-dark radius-50 fz-12"> </span>
                                        </h5>
                                    </div>
                                    {{-- <div class="col-sm-8 col-md-6 col-lg-4">
                                        <!-- Search -->
                                        <form action="{{ url()->current() }}" method="GET">
                                            <div class="input-group input-group-custom input-group-merge">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="tio-search"></i>
                                                    </div>
                                                </div>
                                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                                    placeholder="{{ __('complaint.search_by_complaint_name') }}"
                                                    aria-label="Search" value="{{ $search }}" required>
                                                <button type="submit"
                                                    class="btn btn--primary">{{ __('general.search') }}</button>
                                            </div>
                                        </form>
                                        <!-- End Search -->
                                    </div> --}}
                                    <!-- Search -->
                                    <div class="col-sm-8 col-md-6 col-lg-4">
                                    <form action="{{ url()->current() }}" method="GET">
                                        {{-- <div class="col-md-6 col-lg-4 col-xl-3"> --}}
                                            <div class="form-group">
                                                <label for="worker" class="title-color">{{ __('complaint.worker') }}</label>
                                                <div class="d-flex align-items-center">
                                                    <select class="js-select2-custom form-control me-2" name="worker">
                                                        @forelse ($workers as $worker)
                                                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                    <button type="submit" class="btn btn-primary" name="bulk_action_btn"
                                                        value="update_status">{{ __('general.submit') }}</button>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                        {{-- <div class="input-group input-group-custom input-group-merge">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                 </div>
                                            </div> --}}
                                        {{-- @can('change_users_status')
                                            <div class="remv_control mr-2">
                                                <select name="status" class="mr-3 mt-3 form-control ">
                                                    <option value="">{{ __('dashboard.set_status') }}</option>
                                                    <option value="1">{{ __('dashboard.active') }}</option>
                                                    <option value="2">{{ __('dashboard.disactive') }}</option>
                                                </select>
                                            </div>
                                            @endcan  --}}

                                    </form>
                                    <div class="dropdown">
                                        {{-- <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                            <i class="tio-download-to"></i>
                                            {{__('export')}}
                                            <i class="tio-chevron-down"></i>
                                        </button>
     --}}
                                        {{-- <ul class="dropdown-menu dropdown-menu-right">
                                            <li> --}}
                                                <a type="submit"class="btn btn-outline--primary" href="{{ route('complaint.export') }}">
                                                    <img width="14" src="{{asset('/public/assets/back-end/img/excel.png')}}" alt="">
                                                    {{__('excel')}}
                                                </a>
                                            {{-- </li>
                                        </ul> --}}
                                    </div>
                                    <!-- End Search -->
                                </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="form-group">
                                            <label for="worker" class="title-color">{{ __('companies.region') }}</label>
                                            <div class="d-flex align-items-center">
                                                <select class="js-select2-custom form-control me-2" name="worker">
                                                    @forelse ($workers as $worker)
                                                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                <button type="submit" class="btn btn--primary" name="bulk_action_btn"
                                                    value="update_status">{{ __('general.submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}


                            </div>
                            <div style="text-align: {{ Session::get('locale') === 'ar' ? 'right' : 'left' }};">
                                <div class="table-responsive">
                                    <table id="datatable"
                                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                        <thead class="thead-light thead-50 text-capitalize">
                                            <tr>
                                                <th>{{ __('general.sl') }} <input class="bulk_check_all" type="checkbox" />
                                                </th>
                                                <th class="text-center">{{ __('complaint.complaint_name') }} </th>
                                                <th class="text-center">{{ __('department.department') }} </th>
                                                <th class="text-center">{{ __('complaint.user') }} </th>
                                                <th class="text-center">{{ __('priority.priority') }} </th>
                                                <th class="text-center">{{ __('complaint.complaint_time') }} </th>
                                                <th class="text-center">{{ __('complaint.worker') }} </th>
                                                <th class="text-center">{{ __('general.created_at') }}</th>
                                                <th class="text-center">{{ __('general.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($complaints as $key => $complaint)
                                                <tr>
                                                    <td>{{ $complaints->firstItem() + $key }} <input class="check_bulk_item"
                                                            name="bulk_ids[]" type="checkbox"
                                                            value="{{ $complaint->id }}" /></td>
                                                    <td class="text-center">{{ App\Models\ComplaintManagement::where('id' ,$complaint->name)->first()->name ?? 0 }}</td>
                                                    <td class="text-center">{{ App\Models\Department::where('id' ,$complaint->department_id)->first()->name ?? 0 }} </td>
                                                    <td class="text-center">{{ $complaint->user->name }} </td>
                                                    <td class="text-center">{{ $complaint->priority->name }} </td>
                                                    <td class="text-center">{{ $complaint->description }} </td>
                                                    <td class="text-center">{{  App\Models\User::where('id' ,$complaint->worker)->first()->name ?? "لم تحل بعد!" }} </td>
                                                    <td class="text-center">{{  $complaint->created_at->format('Y-m-d h:m A') }} </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <a class="btn btn-outline-info btn-sm square-btn"
                                                                title="{{ __('general.edit') }}"
                                                                href="{{ route('complaint.edit', $complaint->id) }}">
                                                                <i class="tio-edit"></i>
                                                            </a>
                                                            <a class="btn btn-outline-danger btn-sm delete square-btn"
                                                                title="{{ __('general.delete') }}"
                                                                id="{{ $complaint['id'] }}">
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
                                    {!! $complaints->links() !!}
                                </div>
                            </div>

                            @if (count($complaints) == 0)
                                <div class="text-center p-4">
                                    <img class="mb-3 w-160"
                                        src="{{ asset('public/assets/back-end') }}/svg/illustrations/sorry.svg"
                                        alt="Image Description">
                                    <p class="mb-0">{{ __('general.no_data_to_show') }}</p>
                                </div>
                            @endif
                        </div>
                    {{-- </div> --}}
                </form>

            @endcan
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");
            Swal.fire({
                title: "{{ __('general.are_you_sure_delete_this') }}",
                text: "{{ __('general.you_will_not_be_able_to_revert_this') }}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('general.yes_delete_it') }}!',
                cancelButtonText: '{{ __('general.cancel') }}',
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
                        url: "{{ route('complaint.delete') }}",
                        method: 'get',
                        data: {
                            id: id
                        },
                        success: function() {
                            toastr.success('{{ __('complaint.deleted_successfully') }}');
                            location.reload();
                        }
                    });
                }
            })
        });



        // Call the dataTables jQuery plugin
    </script>
@endpush
