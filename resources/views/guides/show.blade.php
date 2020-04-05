@extends('layout.app')

@section('content')
    <h1 class="text-3xl">{{ __('guide.programme') }}</h1>

    <div class="text-gray-800">
        <h3>{{ $guide->title }}</h3>
        <span>{{ $guide->starts }} - {{ $guide->ends }}</span>
        <img src="{{ $guide->show->logoUrl }}" alt=""/>
    </div>

    <div>
        <h3>{{ __('guide.other_broadcast_times') }}</h3>

        @if(!$otherBroadCastTimes)
            <p>{{ __('guide.no_other_broadcast_times') }}</p>
        @endif

        @foreach($otherBroadCastTimes as $guide)
            <div>
                {{ $guide->channel->title }} - {{ $guide->starts }}
            </div>
        @endforeach
    </div>
@endsection