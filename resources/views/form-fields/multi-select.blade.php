<div class="fv-row mb-8 fv-plugins-icon-container">
    <label class="required fs-6 fw-bold mb-2" for="{{$name}}">{{$label}}</label>
    {!! Form::select($name, $options, $selected, [
    "placeholder" => $placeholder,
    "class" => "form-select form-select-solid",
    'data-control' => "select2",
    'multiple' => true,
    "id" => $name
    ]) !!}
    <div class="text-muted fs-7">
        <span class="text-muted fs-7"><strong id="{{$name}}_error" class="text-danger">{{$errors->first($name)}}</strong></span>
    </div>
    <div class="fv-plugins-message-container invalid-feedback"></div>
</div>