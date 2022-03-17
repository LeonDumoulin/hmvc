@extends('admin.layouts.app',[
    'page_header'=>'المستخدمين',
    'page_description'=>'تعديل مستخدم'
])
@section ('content')
<div class="card card-flush py-4">
    <div class="card-body pt-0">
        <div class="mb-10 fv-row fv-plugins-icon-container">
            {!! Form::open([
                'route' => ['users.update',$record->id],
                'id' => 'myForm',
                'role' => 'form',
                'method' => 'PUT',
                'files' => true,
                ]) !!}
            @include('admin.users.form')
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
