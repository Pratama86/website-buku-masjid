@extends('layouts.app')

@section('title', __('qurban.edit'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('qurban.edit') }}</h3></div>
            {!! Form::model($qurban, ['route' => ['qurban.update', $qurban], 'method' => 'patch']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => __('qurban.name')]) !!}
                {!! FormField::text('year_hijri', ['required' => true, 'label' => __('qurban.year_hijri')]) !!}
                {!! FormField::text('registration_deadline', ['required' => true, 'label' => __('qurban.registration_deadline'), 'class' => 'date-select']) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('qurban.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('qurban.show', __('app.cancel'), [$qurban], ['class' => 'btn btn-default']) }}
                @can('delete', $qurban)
                    <a href="{{ route('qurban.edit', [$qurban, 'action' => 'delete']) }}" id="del-qurban-{{ $qurban->id }}" class="btn btn-danger pull-right">{{__('app.delete')}}</a>
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@if (Request::get('action') == 'delete' && $qurban)
@can('delete', $qurban)
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-danger">
                <div class="panel-heading"><h3 class="panel-title">{{ __('qurban.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label">{{ __('qurban.name') }}</label>
                    <p>{{ $qurban->name }}</p>
                    {!! $errors->first('qurban_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['qurban.destroy', $qurban]],
                        __('app.delete_confirm_button'),
                        ['class' => 'btn btn-danger'],
                        [
                            'qurban_id' => $qurban->id,
                        ]
                    ) !!}
                    {{ link_to_route('qurban.edit', __('app.cancel'), [$qurban], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        </div>
    </div>
@endcan
@endif
@endsection

@push('scripts')
<script>
    $('.date-select').datepicker({ 
        format: 'yyyy-mm-dd',
        autoclose: true 
    });
</script>
@endpush