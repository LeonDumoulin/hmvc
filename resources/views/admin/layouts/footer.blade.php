<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('dashboard/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('dashboard/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('dashboard/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<script src="{{asset('dashboard/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('dashboard/js/widgets.bundle.js')}}"></script>
<script src="{{asset('dashboard/js/custom/widgets.js')}}"></script>
<script src="{{asset('dashboard/js/custom/apps/chat/chat.jss')}}"></script>
<script src="{{asset('dashboard/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('dashboard/js/custom/utilities/modals/create-app.js')}}"></script>
<script src="{{asset('dashboard/js/custom/utilities/modals/users-search.js')}}"></script>
<!--end::Page Custom Javascript-->


<!--begin::Datatable(used by all pages)-->
<script src="{{asset('dashboard/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Datatable(used by all pages)-->

<!--end::Javascript-->
@stack('scripts')


@include('admin.layouts.scripts.delete')
@include('admin.layouts.scripts.plugins')
