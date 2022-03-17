<div class="fv-row mb-8 fv-plugins-icon-container" data-kt-password-meter="true">
    <label class="required fs-6 fw-bold mb-2" for="{{$name}}">{{$label}}</label>       
    <span class="text-muted fs-7"><strong id="{{$name}}_error" class="text-danger">{{$errors->first($name)}}</strong></span>
    <div class="position-relative mb-3">
        <input type="password" class="form-control form-control-solid" placeholder="{{$label}}" name="{{$name}}">
    </div>
    <!--begin::Highlight meter-->
    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
    </div>
    <!--end::Highlight meter-->
    <!--begin::Hint-->
    <div class="text-muted">
        Use 8 or more characters with a mix of letters, numbers & symbols.
    </div>
    <!--end::Hint-->
    <div class="fv-plugins-message-container invalid-feedback"></div>
</div>
