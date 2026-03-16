<table class="calendar-table" border="1">
    <thead>
        <tr>
            <th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @php $cnt = 0; @endphp

            {{-- 1日の曜日まで空のマスを作る --}}
            @for ($i = 0; $i < $firstDayOfWeek; $i++)
                <td></td>
                @php $cnt++; @endphp
            @endfor

            {{-- 1日から月末までループ --}}
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $dateStr = $currentMonth->copy()->day($day)->format('Y-m-d');
                    $dayHistories = $histories->get($dateStr, collect());
                @endphp

                <td class="{{ $dayHistories->isNotEmpty() ? 'has-history' : '' }}">
                    {{-- 日付部分をクリックで新規登録モーダル --}}
                    <div class="day-number" onclick="showModal('{{ $dateStr }}','{{ route('admin.totonoi_history.add') }}')">
                        {{ $day }}
                    </div>

                    @foreach($dayHistories as $history)
                        {{-- 各履歴をクリックで編集モーダル（IDを渡す） --}}
                        <div class="history-badge" onclick="showEditModal('{{ $history->id }}')">
                            ♨️ {{ $history->sauna->name }}
                        </div>
                    @endforeach
                </td>

                @php $cnt++; @endphp

                {{-- 土曜日(7列目)で改行 --}}
                @if ($cnt % 7 == 0)
                    </tr><tr>
                @endif
            @endfor

            {{-- 最後の空マスを埋める --}}
            @while ($cnt % 7 != 0)
                <td></td>
                @php $cnt++; @endphp
            @endwhile
        </tr>
    </tbody>
</table>
<div id="form-display-area-overray" onclick="closeModal()"></div>
<div id="form-display-area"></div>
