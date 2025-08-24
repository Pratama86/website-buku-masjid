@extends('layouts.app')

@section('title', __('qurban.list'))

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ __('qurban.list') }}</h1>
    <div class="page-subtitle">{{ __('app.total') }} : {{ $qurbanEvents->count() }} {{ __('qurban.qurban') }}</div>
    <div class="page-options">
        @can('create', new App\Models\QurbanEvent)
            {{ link_to_route('qurban.create', __('qurban.create'), [], ['class' => 'btn btn-success']) }}
        @endcan
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('qurban.search') }}</label>
                        <input placeholder="{{ __('qurban.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('qurban.search') }}" class="btn btn-secondary">
                    <a href="{{ route('qurban.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            @if($qurbanEvents->isNotEmpty())
                <table class="table table-sm table-responsive-sm table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">{{ __('app.table_no') }}</th>
                            <th>{{ __('qurban.name') }}</th>
                            <th>{{ __('qurban.year_hijri') }}</th>
                            <th>{{ __('qurban.registration_deadline') }}</th>
                            <th class="text-center">{{ __('app.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($qurbanEvents as $key => $qurbanEvent)
                        <tr>
                            <td class="text-center">{{ $qurbanEvents->firstItem() + $key }}</td>
                            <td>{{ $qurbanEvent->name }}</td>
                            <td>{{ $qurbanEvent->year_hijri }}</td>
                            <td>{{ $qurbanEvent->registration_deadline }}</td>
                            <td class="text-center">
                                @can('view', $qurbanEvent)
                                    {{ link_to_route(
                                        'qurban.show', 
                                        __('app.show'), 
                                        [$qurbanEvent],
                                        ['class' => 'btn btn-sm btn-secondary']
                                    ) }}
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card-body">{{ $qurbanEvents->appends(Request::except('page'))->render() }}</div>
            @else
                <div class="card-body">{{ __('qurban.empty') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection