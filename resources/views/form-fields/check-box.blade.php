<div class="fv-row mb-8 fv-plugins-icon-container">
    <label class="col-lg-4 col-form-label required fw-bold fs-6" for="{{$name}}">{{$label}}</label>
    <div class="col-lg-8 fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
        <!--begin::Options-->
        <div class="d-flex align-items-center mt-3">
            <!--begin::Option-->
            @foreach ($options as $name => $value)
                <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                    <input class="form-check-input" name="{{$value}}[]" type="checkbox" value="{{$name}}">
                    <span class="fw-bold ps-2 fs-6">{{$value}}</span>
                </label>
            @endforeach
            <!--end::Option-->
        </div>
        <!--end::Options-->
    <div class="fv-plugins-message-container invalid-feedback"></div></div>
    <!--end::Col-->
</div>