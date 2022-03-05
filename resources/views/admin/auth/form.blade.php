<div data-kt-stepper-element="content" class="current">
    <div class="w-100">
        {!! App\Helper\Field::text('username',__('الأسم'),$record->name) !!} 
        {!! App\Helper\Field::email('email',__('البريد اﻹلكتروني'),$record->email) !!}
        {!! App\Helper\Field::password('old-password',__('كلمة السر الحالية')) !!}
        {!! App\Helper\Field::password('password',__('كلمة السر الجديدة')) !!}
        {!! App\Helper\Field::password('password_confirmation',__('تأكيد كلمة السر')) !!}
    </div>
</div>