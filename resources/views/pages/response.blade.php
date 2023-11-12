<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    @vite('resources/css/app.css')
</head>
<body>
    <div class="container mx-auto p-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Table ticketing</h1>
        </div>

        <div class="space-y-4">
            @foreach ($transactions as $transaction)
                <div class="bg-gray-100 p-4 rounded shadow-md">
                    <div class="mb-4">
                        <div class="font-bold">Transaction Code: <u>{{ $transaction->transaction_code }}</u></div>
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach ($transaction->tickets as $ticket)
                            <li class="mb-2">
                                <div class="font-bold">Ticket Code: {{ $ticket->ticket_code }}</div>
                                <ul class="list-disc list-inside pl-4">
                                    @foreach ($ticket->bets as $bet)
                                        <li class="mb-1">
                                            <div class="font-bold">Number Bet: <u>{{ $bet->number_bet }}</u></div>
                                            <div>Ticket Type: <u>{{ getTicketTypeText($bet->ticket_type) }}</u></div>
                                            <div>Draw Time: <u>{{ getDrawTimeText($bet->draw_time) }}</u></div>
                                            <div>Amount Bet: ₱<u>{{ $bet->amount_bet }}</u></div>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Custom Tailwind CSS styled pagination links -->
        <div class="flex justify-between mt-6">
            <span class="text-sm">
                {{-- Displaying current page and total pages --}}
                Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }}
            </span>
            
            <div class="flex items-center">
                {{-- Previous Page Link --}}
                @if ($transactions->onFirstPage())
                    <span class="mr-2 cursor-not-allowed opacity-50" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <a href="{{ $transactions->previousPageUrl() }}" class="mr-2">
                        {!! __('pagination.previous') !!}
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if ($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}" class="ml-2">
                        {!! __('pagination.next') !!}
                    </a>
                @else
                    <span class="ml-2 cursor-not-allowed opacity-50" aria-disabled="true" aria-label="@lang('pagination.next')">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>
        </div>
    </div>


@php
    function getTicketTypeText($ticketType) {
        switch ($ticketType) {
            case 'type_A':
                return '8-11 AM';
            case 'type_B':
                return '1-5 PM';
            default:
                return $ticketType;
        }
    }

    function getDrawTimeText($drawTime) {
        switch ($drawTime) {
            case 'draw_A':
                return 'Target';
            case 'draw_B':
                return 'Rambal';
            default:
                return $drawTime;
        }
    }
@endphp

</body>
</html>