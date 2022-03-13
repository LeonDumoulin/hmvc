@extends('admin.layouts.app',[
    'page_header'=>'المستخدمين',
    'page_description'=>''
])
@section ('content')
<div class="card">
    <!--begin::Card body-->
    <div class="card-body py-4">
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack mb-5">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers"/>
            </div>
            <!--end::Search-->
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                <!--begin::Add-->
                <a href="{{route('users.create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>{{__('اضافة مستخدم جديد')}}
                </a>
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="tooltip">
                    <span class="svg-icon svg-icon-2">...</span>
                    Add Customer
                </button> --}}
                <!--end::Add-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Datatable-->
        <div class="table-responsive">
            <table id="kt_datatable_example_1" class="table align-middle table-row-dashed table-hover table-bordered g-4">
                <thead>
                <tr class="text-start fw-bolder text-uppercase">
                    <th >#</th>
                    <th >{{__('إسم المستخدم')}}</th>
                    <th >{{__('البريد الإلكتروني')}}</th>
                    {{-- <th >{{__('الصلاحيات')}}</th> --}}
                    {{-- <th >{{__('إجراء')}}</th> --}}
                </tr>
                </thead>
                {{-- <tbody class="fw-bold">
                    @foreach ($records as $record )
                    <tr>
                        <td class="text-canter">{{$record->id}}</td>
                        <td class="text-canter">{{$record->name}}</td>
                        <td class="text-canter">{{$record->email}}</td>
                        <td class="text-canter">
                            <div class="badge badge-success fw-bolder">Yesterday</div>
                            <div class="badge badge-success fw-bolder">Yesterday</div>
                            <div class="badge badge-success fw-bolder">Yesterday</div> --}}
                            {{-- @foreach($record->roles as $role)
                                                
                                            @endforeach --}}
                        {{-- </td>
                        <td class="text-muted">
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">{{__('اجراء')}}
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                            <span class="svg-icon svg-icon-5 m-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon--></a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{route('users.edit',$record->id)}}" class="menu-link px-3 text-primary">{{__('تعديل')}}&nbsp;&nbsp;<i class="fa fa-edit text-primary"></i></a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 text-danger">
                                    <a href="{{route('users.destroy',$record->id)}}" class="menu-link px-3 text-danger" data-kt-users-table-filter="delete_row">{{__('حذف')}}&nbsp;&nbsp;<i class="fa fa-trash text-danger"></i></a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </tr>
                    @endforeach
                </tbody> --}}
            </table>
        </div>
        <!--end::Datatable-->
    </div>
</div>

@endsection
@push('scripts')
<script>
"use strict";

// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_example_1").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            // order: [1, 'desc'],
            stateSave: true,
            ajax: {
                url: "{{route('admin.users.list')}}",
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                // { data: null },
            ],
            // columnDefs: [
            //     {
            //         targets: 0,
            //         orderable: false,
            //         render: function (data) {
            //             return `
            //                 <div class="form-check form-check-sm form-check-custom form-check-solid">
            //                     <input class="form-check-input" type="checkbox" value="${data}" />
            //                 </div>`;
            //         }
            //     },
            //     {
            //         targets: 4,
            //         render: function (data, type, row) {
            //             return `<img src="${hostUrl}media/svg/card-logos/${row.CreditCardType}.svg" class="w-35px me-3" alt="${row.CreditCardType}">` + data;
            //         }
            //     },
            //     {
            //         targets: -1,
            //         data: null,
            //         orderable: false,
            //         className: 'text-end',
            //         render: function (data, type, row) {
            //             return `
            //                 <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
            //                     Actions
            //                     <span class="svg-icon svg-icon-5 m-0">
            //                         <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            //                             <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            //                                 <polygon points="0 0 24 0 24 24 0 24"></polygon>
            //                                 <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
            //                             </g>
            //                         </svg>
            //                     </span>
            //                 </a>
            //                 <!--begin::Menu-->
            //                 <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
            //                     <!--begin::Menu item-->
            //                     <div class="menu-item px-3">
            //                         <a href="#" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
            //                             Edit
            //                         </a>
            //                     </div>
            //                     <!--end::Menu item-->

            //                     <!--begin::Menu item-->
            //                     <div class="menu-item px-3">
            //                         <a href="#" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
            //                             Delete
            //                         </a>
            //                     </div>
            //                     <!--end::Menu item-->
            //                 </div>
            //                 <!--end::Menu-->
            //             `;
            //         },
            //     },
            // ],
            // Add data-filter attribute
             createdRow: function (row, data, dataIndex) {
                $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            }
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    
    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector('#kt_datatable_example_1');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });
    }

    

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleFilterDatatable();
            handleDeleteRows();
            handleResetForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

</script>
@endpush --}}