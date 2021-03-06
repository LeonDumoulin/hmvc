@extends('admin.layouts.app',[
    'page_header'=>'رتب المستخدمين',
    'page_description'=>'إضافة رتبة'
])
@section ('content')
<div class="card card-flush py-4">
    <div class="card-body pt-0">
        <div class="mb-10 fv-row fv-plugins-icon-container">
            {!! Form::open([
                'route' => 'admin.roles.store',
                'id' => 'myForm',
                'role' => 'form',
                'method' => 'POST',
                'files' => true,
                ]) !!}
            @include('authorization::form')
        </div>
        <div class="d-flex justify-content-end">
            <!--begin::Button-->
            <a href="{{ URL::previous() }}" id="kt_ecommerce_add_product_cancel" class="btn btn-danger me-5">{{__('العودة')}}</a>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                <span class="indicator-label">{{__('حفظ')}}</span>
                <span class="indicator-progress">{{__('برجاء الإنتظار')}}...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
        </div>
        {!! Form::close()!!}
    </div>
</div>
@endsection
