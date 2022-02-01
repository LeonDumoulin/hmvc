<input type="text" class="form-control" value="{{$value}}" name="{{$name}}" id="{{$name}}_wrap"
    placeholder="{{$label}}" />
@if ($errors->has($name))
<div>{{ $errors->first($name) }}</div>
@endif
