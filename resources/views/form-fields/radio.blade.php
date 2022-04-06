{{-- <div class="fv-row mb-8 fv-plugins-icon-container">
    <label class="required fs-6 fw-bold mb-2" for="{{$name}}">{{$label}}</label>
    {!! Form::select($name, $options, $selected, [
    "placeholder" => $placeholder,
    "class" => "form-select form-select-solid",
    'data-control' => "select2",
    "id" => $name
    ]) !!}
    <div class="text-muted fs-7">
        <span class="text-muted fs-7"><strong id="{{$name}}_error" class="text-danger">{{$errors->first($name)}}</strong></span>
    </div>
    <div class="fv-plugins-message-container invalid-feedback"></div>
</div> --}}


<div class="fv-row mb-8 fv-plugins-icon-container">
    <label class="required fs-6 fw-bold mb-2" for="{{$name}}">{{$label}}</label>
    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
        <!--begin::Options-->
        <div class="d-flex align-items-center mt-3">
            @foreach ($options as $name => $value)
                <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="{{$name}}">
                    <input class="form-check-input" type="checkbox" value="{{$value}}" name="{{$name}}" id="kt_user_menu_dark_mode_toggle">
                    <span class="pulse-ring ms-n1"></span>
                    <span class="form-check-label text-gray-600 fs-7">{{$name}}</span>
                </label>
                &nbsp;&nbsp;
                &nbsp;&nbsp;
            @endforeach
        </div>
    </div>
</div>