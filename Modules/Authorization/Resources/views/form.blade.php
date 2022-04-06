@inject('permissionModel','Spatie\Permission\Models\Permission')
<div data-kt-stepper-element="content" class="current">
    <div class="w-100">
        {!! App\Helper\Field::text('name',__('إسم الرتبة'),$model->name) !!}
        {{-- {!! App\Helper\Field::textArea('description',__('الوصف'),$model->description) !!} --}}
        <div class="form-group" id="permissions_wrap">
            <div class="form-group" id="permissions_wrap">
                <h2>
                    <label for="permissions" class="col-form-label required fw-bold fs-6">{{ __('الصلاحيات') }}</label>
                    <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                        <input type="checkbox" id="selectAll" class="form-check-input">
                        <label class="fw-bold ps-2 fs-6 text-primary" for="selectAll">{{ __('تحديد الكل') }}</label>
                    </label>
                </h2>
                <div class="">
                    <div class="clearfix"></div>
                    @inject('permissionModel','Spatie\Permission\Models\Permission')
                    @foreach( $permissions as $type)
                        <h2>
                            <label>{{ __($type->goup) }}</label>
                            <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                <input type="checkbox" id="{{ str_replace(' ', '_', __($type->group)) }}" class="form-check-input selectSameGroup">
                                <label class="fw-bold ps-2 fs-6 text-primary m-1" for="{{ str_replace(' ', '_', __($type->group)) }}">{{ __('تحديد الكل') }}</label>
                            </label>
                        </h2>
                        <div class="form-group row" id="permissions_wrap">
                        @foreach($permissionModel->where('group',$type->group)->get() as $item)
                                <div class="m-1 col-md-3">
                                    <label class="form-check form-check-inline form-check-solid me-5 is-valid">
                                        {!! Form::checkBox('permissions[]',$item->id,$model->hasPermissionTo($item) ? true : false,['class' => str_replace(' ', '_', __($type->group))." form-check-input"]) !!}
                                        <label for="{{$item->name}}" class="">{{ __($item->name) }}</label>
                                    </label>
                                </div>
                                @if($loop->last)
                                <div class="clearfix"></div>
                                <hr>
                                @endif
                        @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $("#selectAll").click(function () {
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });

        $(".selectSameGroup").click(function () {
            let group = $(this).attr('id');
            console.log(group);
            $('.'+group).prop('checked', $(this).prop('checked'));
        });
    </script>
@endpush
