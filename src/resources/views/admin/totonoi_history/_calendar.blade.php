@php
    $palette = [
        '#3ab0cf',
        '#114c81',
        '#2d7a6e',
        '#00796b',
        '#5c6bc0',
    ];
@endphp

<table class="calendar-table" border="1">
    <thead>
        <tr>
            <th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @php $cnt = 0; @endphp

            @for ($i = 0; $i < $firstDayOfWeek; $i++)
                <td></td>
                @php $cnt++; @endphp
            @endfor

            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $dateStr = $currentMonth->copy()->day($day)->format('Y-m-d');
                    $dayHistories = $histories->get($dateStr, collect());
                @endphp

                <td class="{{ $dayHistories->isNotEmpty() ? 'has-history' : '' }}">
                    <div class="day-number" onclick="showModal('{{ $dateStr }}','{{ route('admin.totonoi_history.add') }}')">
                        {{ $day }}
                        <img class="add-sakatsu" src="{{ asset('images/icons/icon-add.png') }}" alt="追加">
                    </div>

                    @foreach($dayHistories as $history)
                        @php
                            $colorIndex = $history->sauna->id % count($palette);
                            $badgeColor = $palette[$colorIndex];
                        @endphp

                        <div class="history-badge"
                        style="background-color: {{ $badgeColor }}; color: #fff; padding: 2px 4px; border-radius: 3px; margin-bottom: 2px;"
                        onclick="showEditModal('{{ $history->id }}')">
                            ♨️ {{ $history->sauna->name }}
                        </div>
                    @endforeach
                </td>

                @php $cnt++; @endphp

                @if ($cnt % 7 == 0)
                    </tr><tr>
                @endif
            @endfor

            @while ($cnt % 7 != 0)
                <td></td>
                @php $cnt++; @endphp
            @endwhile
        </tr>
    </tbody>
</table>
<div id="form-display-area-overray" onclick="closeModal()"></div>
<div id="form-display-area"></div>
