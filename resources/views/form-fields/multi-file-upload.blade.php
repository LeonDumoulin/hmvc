<div class="fv-row mb-8 fv-plugins-icon-container">
    <div class="form-group {{$errors->has($name) ? 'has-error':'' }}" id="{{$name}}_wrap">
    <label class="required fs-6 fw-bold mb-2" for="{{$name}}">{{$label}}</label>       
            {!! Form::file($name.'[]', [
            "placeholder" => $label,
            "class" => "form-control ".$plugin,
            "multiple" => "multiple",
            "data-preview-file-type" => "text",
            "id" => $name,
            "required"
            ]) !!}
        <div class="text-muted fs-7">
            <span class="text-muted fs-7"><strong id="{{$name}}_error" class="text-danger">{{$errors->first($name)}}</strong></span>
        </div>
        <div class="fv-plugins-message-container invalid-feedback"></div>
    </div>   
</div>