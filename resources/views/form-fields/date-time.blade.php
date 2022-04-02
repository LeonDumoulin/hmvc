<div class="fv-row mb-8 fv-plugins-icon-container">
    <label class="required fs-6 fw-bold mb-2" for="{{$name}}">{{$label}}</label>
    {!! Form::date($name, $value, [
    "placeholder" => $label,
    "class" => "form-control form-control-solid",
    "id" => $name,
    ]) !!}
    <div class="text-muted fs-7">
        <span class="text-muted fs-7"><strong id="{{$name}}_error" class="text-danger">{{$errors->first($name)}}</strong></span>
    </div>
    <div class="fv-plugins-message-container invalid-feedback"></div>
</div>