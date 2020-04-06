@extends('layout.app')

@section('content')
    <h1 class="text-3xl">{{ __('guide.programme') }} - {{ $date }}</h1>

    @if(count($daysSelection) !== 0)
        <div class="mb-3">
            <span>
                <span class="text-sm">{{ __('guide.programme_dates') }}:</span>
                @foreach($daysSelection as $date)
                    <a href="{{ route('guides.index', ['date' => $date]) }}" class="text-xs text-blue-500 hover:underline">{{ $date }}</a>
                @endforeach
            </span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach($channels as $channel)
            <div class="bg-gray-100 py-5 px-6">
                <h3 class="text-3xl text-gray-800 mb-3">{{ $channel->title }}</h3>

                @if(count($channel->guides) === 0)
                    <div class="text-md text-gray-800">{{ __('guide.empty_schedule') }}</div>
                @endif

                @foreach($channel->guides as $guide)
                    <div class="mb-1">
                        <div class="text-md text-gray-800">
                            @if($guide->hasActiveShow())
                                <a href="{{ route('guides.show', $guide) }}" class="hover:text-blue-500 hover:underline">{{ $guide->title }}</a>
                            @else
                                {{ $guide->title }}
                            @endif
                        </div>
                        <div class="text-xs text-gray-600" data-timestamp-to-local="{{ $guide->starts }}" data-datetime-format="HH:mm">{{ $guide->formattedStartTime }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection