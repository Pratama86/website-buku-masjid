@extends('layouts.app')

@section('title', __('qurban.detail'))

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('qurban.detail') }}</h3></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('qurban.name') }}</td><td>{{ $qurban->name }}</td></tr>
                        <tr><td>{{ __('qurban.year_hijri') }}</td><td>{{ $qurban->year_hijri }}</td></tr>
                        <tr><td>{{ __('qurban.registration_deadline') }}</td><td>{{ $qurban->registration_deadline }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $qurban)
                    {{ link_to_route('qurban.edit', __('qurban.edit'), [$qurban], ['class' => 'btn btn-warning', 'id' => 'edit-qurban-'.$qurban->id]) }}
                @endcan
                @can('delete', $qurban)
                    <a href="{{ route('qurban.edit', [$qurban, 'action' => 'delete']) }}" id="del-qurban-{{ $qurban->id }}" class="btn btn-danger pull-right">{{__('app.delete')}}</a>
                @endcan
                {{ link_to_route('qurban.index', __('qurban.back_to_index'), [], ['class' => 'btn btn-link']) }}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('qurban_offering.list') }}</h3>
                <div class="card-options">
                    @can('create', new App\Models\QurbanOffering)
                        {{ link_to_route('qurban.offerings.create', __('qurban_offering.create'), $qurban, ['class' => 'btn btn-success btn-sm']) }}
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @forelse($qurban->offerings as $offering)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="card-title">{{ $offering->name }} - {{ format_number($offering->price) }}</h4>
                            <div class="card-options">
                                @can('update', $offering)
                                    {{ link_to_route(
                                        'qurban.offerings.edit',
                                        __('app.edit'),
                                        [$qurban, $offering],
                                        ['class' => 'btn btn-sm btn-warning']
                                    ) }}
                                @endcan
                            </div>
                        </div>
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>{{ __('qurban_participant.name') }}</th>
                                    <th>{{ __('qurban_participant.phone_number') }}</th>
                                    <th>{{ __('qurban_participant.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($offering->participants as $key => $participant)
                                <tr>
                                    <td class="text-center">{{ 1 + $key }}</td>
                                    <td>{{ $participant->name }}</td>
                                    <td>{{ $participant->phone_number }}</td>
                                    <td>{{ $participant->status }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4">{{ __('qurban_participant.empty') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @empty
                    <p>{{ __('qurban_offering.empty') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection