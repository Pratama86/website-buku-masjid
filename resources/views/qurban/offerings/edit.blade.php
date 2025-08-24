@extends('layouts.app')

@section('title', __('qurban_offering.edit'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @if (request('action') == 'delete' && $offering)
        @can('delete', $offering)
            <div class="panel panel-danger">
                <div class="panel-heading"><h3 class="panel-title">{{ __('qurban_offering.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label">{{ __('qurban_offering.name') }}</label>
                    <p>{{ $offering->name }}</p>
                    {!! $errors->first('offering_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['qurban.offerings.destroy', $qurban, $offering]],
                        __('app.delete_confirm_button'),
                        ['class' => 'btn btn-danger'],
                        [
                            'offering_id' => $offering->id,
                        ]
                    ) !!}
                    {{ link_to_route('qurban.offerings.edit', __('app.cancel'), [$qurban, $offering], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        @endcan
        @else
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('qurban_offering.edit') }}</h3></div>
            {!! Form::model($offering, ['route' => ['qurban.offerings.update', $qurban, $offering], 'method' => 'patch']) !!}
            <div class="panel-body">
                {!! FormField::select('type', ['Kambing' => 'Kambing', 'Sapi' => 'Sapi', 'Sapi 1/7' => 'Sapi 1/7'], ['required' => true, 'label' => __('qurban_offering.type')]) !!}
                {!! FormField::text('name', ['required' => true, 'label' => __('qurban_offering.name')]) !!}
                {!! FormField::price('price', ['required' => true, 'label' => __('qurban_offering.price'), 'currency' => config('money.currency_code')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('qurban_offering.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('qurban.show', __('app.cancel'), $qurban, ['class' => 'btn btn-default']) }}
                @can('delete', $offering)
                    <a href="{{ route('qurban.offerings.edit', [$qurban, $offering, 'action' => 'delete']) }}" id="del-offering-{{ $offering->id }}" class="btn btn-danger pull-right">{{__('app.delete')}}</a>
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif
@endsection