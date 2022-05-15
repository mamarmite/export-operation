<div class="dropdown d-inline-block">
    <button class="btn btn-secondary dropdown-toggle" id="exportOperationTypeSelectorDropdown" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="la la-download"></i> {{ trans('export-operation::export.export-all') }} {{ $crud->entity_name_plural }}
    </button>
    <div class="dropdown-menu" aria-labelledby="exportOperationTypeSelectorDropdown" style="width: 100%;">
        <h6 class="dropdown-header">@lang('export-operation::export.in-type')</h6>
        @foreach(config('backpack.crud.operations.export.fileType') as $type)
            @php
            $type = Str::lower($type);
            @endphp
        <a class="dropdown-item d-block" href="{{ url($crud->route.'/export/'.$type) }}" class="btn btn-primary">
            <span class="la la-file-{{$type}} la-lg"></span>@lang('export-operation::export.type-'.$type)</span>
        </a>
        @endforeach
    </div>
</div>

