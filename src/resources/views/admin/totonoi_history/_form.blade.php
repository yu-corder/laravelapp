@php
    $isEdit = isset($history);
    $action = $isEdit ? route('admin.totonoi_history.edit', $history->id) : route('admin.totonoi_history.add');
@endphp
<div class="registration-form">
    <h2 class="">{{ $isEdit ? 'サ活編集' : 'サ活登録' }}</h2>
    <form id="sa-katsu-form" action="{{ $action }}" method="post">
        @csrf
        <div>
            <label for="form-visit-date">サ活日</label>
            <input type="date" name="visit_date" id="form-visit-date"
                   value="{{ $isEdit ? $history->visit_date : '' }}"
                   readonly>
        </div>
        <div>
            <label for="addname">サウナ名</label>
            <select id="addname" name="sauna_id">
                @foreach($saunas as $sauna)
                    <option value="{{ $sauna->id }}"
                        {{ ($isEdit && $history->sauna_id == $sauna->id) ? 'selected' : '' }}>
                        {{ $sauna->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="sa-katsu-button-group">
            <button class="tbl-btn c-btn--delete sa-katsu-button" type="button" onclick="closeModal()">閉じる</button>
            @if($isEdit)
                {{-- 編集時のみ削除ボタンを表示 --}}
                <button class="tbl-btn c-btn--delete sa-katsu-button" type="button"
                        onclick="if(confirm('このサ活記録を削除しますか？')){ deleteHistory('{{ $history->id }}'); }">
                    削除
                </button>
            @endif
            <input class="tbl-btn c-btn--primary sa-katsu-button" type="submit" name="send" value="{{ $isEdit ? '更新' : '登録' }}">
        </div>
    </form>
</div>
