<div class="dropdown d-inline-block">
    <button class="btn btn-secondary dropdown-toggle" id="exportOperationTypeSelectorDropdown" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="la la-download"></i> {{ trans('export-operation::export.export') }} {{ $crud->entity_name_plural }}
    </button>
    <div class="dropdown-menu" aria-labelledby="exportOperationTypeSelectorDropdown" style="width: 100%;">
        <a class="dropdown-item d-block" href="{{ url($crud->route.'/export') }}" class="btn btn-primary">
            <span>@lang('export-operation::export.in-type')</span><span class="la la-file-csv la-lg"></span><!--<span class="badge bg-primary rounded-pill">@lang('export-operation::export.type-csv')</span>-->
        </a>
    </div>
</div>

