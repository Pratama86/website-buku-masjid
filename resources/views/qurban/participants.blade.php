@extends('layouts.app')

@section('title', __('qurban.participants'))

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('qurban.participants') }} - {{ $qurban->name }}</h3>
        <div class="card-options">
            {{ link_to_route('qurban.show', __('app.back'), $qurban, ['class' => 'btn btn-outline-primary btn-sm']) }}
        </div>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>{{ __('qurban_participant.name') }}</th>
                    <th>{{ __('qurban_participant.offering') }}</th>
                    <th>{{ __('qurban_participant.phone_number') }}</th>
                    <th>{{ __('qurban_participant.status') }}</th>
                    <th>{{ __('qurban_participant.photo') }}</th>
                    <th>{{ __('app.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @php $number = 1; @endphp
                @foreach ($qurban->offerings as $offering)
                    @foreach ($offering->participants as $participant)
                        <tr>
                            <td class="text-center">{{ $number++ }}</td>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->offering ? $participant->offering->name : '' }}</td>
                            <td>{{ $participant->phone_number }}</td>
                            <td>{{ $participant->status }}</td>
                            <td>
                                @if ($participant->photo_path)
                                    <img src="{{ asset('storage/' . $participant->photo_path) }}" alt="{{ $participant->name }}" style="width: 100px;">
                                @endif
                            </td>
                            <td>
                                @can('delete', $participant)
                                    <form action="{{ route('qurban.participants.destroy', [$qurban, $participant]) }}" method="POST" onsubmit="return confirm('{{ __('qurban_participant.delete_confirm') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('app.delete') }}</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
