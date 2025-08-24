@extends('layouts.app')

@section('title', __('qurban_offering.create'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('qurban_offering.create') }}</h3></div>
            {!! Form::open(['route' => ['qurban.offerings.store', $qurban]]) !!}
            <div class="panel-body">
                {!! FormField::select('type', ['Kambing' => 'Kambing', 'Sapi' => 'Sapi', 'Sapi 1/7' => 'Sapi 1/7'], ['required' => true, 'label' => __('qurban_offering.type')]) !!}
                {!! FormField::text('name', ['required' => true, 'label' => __('qurban_offering.name')]) !!}
                {!! FormField::price('price', ['required' => true, 'label' => __('qurban_offering.price'), 'currency' => config('money.currency_code')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('qurban_offering.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('qurban.show', __('app.cancel'), $qurban, ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection