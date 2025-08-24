@extends('layouts.app')

@section('title', __('qurban.create'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('qurban.create') }}</h3></div>
            {!! Form::open(['route' => 'qurban.store']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => __('qurban.name')]) !!}
                {!! FormField::text('year_hijri', ['required' => true, 'label' => __('qurban.year_hijri')]) !!}
                {!! FormField::text('registration_deadline', ['required' => true, 'label' => __('qurban.registration_deadline'), 'class' => 'date-select']) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('qurban.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('qurban.index', __('app.cancel'), [], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.date-select').datepicker({ 
        format: 'yyyy-mm-dd',
        autoclose: true 
    });
</script>
@endpush