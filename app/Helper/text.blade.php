
            <label class="required form-label" for="{{$name}}">{{$label}}</label>
            {!! Form::text($name, $value, [
            "placeholder" => $label,
            "class" => "form-control mb-2",
            "id" => $name,
            'required',
            ]) !!}
            <div class="text-muted fs-7">
                <span class="text-muted fs-7"><strong id="{{$name}}_error">{{$errors->first($name)}}</strong></span>
            </div>
            <div class="fv-plugins-message-container invalid-feedback"></div>
     