@extends('layout.app')

@section('content')
    <a href="{{ route('guides.index') }}">< {{ __('guide.go_back_full') }}</a>

    <h1 class="text-3xl">{{ __('guide.programme') }}</h1>

    <div class="text-gray-800 mb-4">
        <h3>{{ $guide->title }}</h3>
        <div class="mb-1">
            <span data-timestamp-to-local="{{ $guide->starts }}" data-datetime-format="MM-DD HH:mm">{{ $guide->formattedStartDateTime }}</span> -
            <span data-timestamp-to-local="{{ $guide->ends }}" data-datetime-format="HH:mm">{{ $guide->formattedEndTime }}</span>
        </div>
        <img src="{{ $guide->show->logoUrl }}" alt=""/>
    </div>

    <div>
        <h3 class="text-2xl">{{ __('guide.other_broadcast_times') }}</h3>

        @if($otherBroadCastTimes->count() === 0)
            <p>{{ __('guide.no_other_broadcast_times') }}</p>
        @endif

        @foreach($otherBroadCastTimes as $guide)
            <div>
                <a href="{{ route('guides.show', $guide) }}" class="hover:underline hover:text-blue-500">
                    <span class="font-bold">{{ $guide->channel->title }}</span>:
                    <span data-timestamp-to-local="{{ $guide->starts }}" data-datetime-format="YYYY-MM-DD HH:mm">{{ $guide->formattedFullDateTime }}</span>
                </a>
            </div>
        @endforeach
    </div>
@endsection