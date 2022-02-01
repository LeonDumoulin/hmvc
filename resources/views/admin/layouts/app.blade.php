<!DOCTYPE html>

<html direction="rtl" dir="rtl" style="direction: rtl">
    @include('admin.layouts.header')
    <body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed toolbar-tablet-and-mobile-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">


        <div class="d-flex flex-column flex-root">
            <div class="page d-flex flex-row flex-column-fluid">
                <!--start::Sidebar-->
                @include('admin.layouts.sidebar')
                <!--end::Sidebar-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @include('admin.layouts.navbar')
                    @include('admin.layouts.main')
                    @include('admin.layouts.dashboard-footer')
                </div>
            </div>
        </div>
        @include('admin.layouts.drawers')
        @include('admin.layouts.footer')
    </body>
</html>