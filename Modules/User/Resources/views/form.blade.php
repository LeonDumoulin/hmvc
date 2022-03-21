<div data-kt-stepper-element="content" class="current">
    <div class="w-100">
        {!! App\Helper\Field::text('name',__('الأسم'),$record->name) !!}
        {!! App\Helper\Field::email('email',__('البريد اﻹلكتروني'),$record->email) !!}
        {!! App\Helper\Field::password('password',__('كلمة السر')) !!}
        {!! App\Helper\Field::password('password_confirmation',__('تأكيد كلمة السر')) !!}
        {!! App\Helper\Field::checkbox('roles',__('الرتب'),$roles) !!}
    </div>
</div>
