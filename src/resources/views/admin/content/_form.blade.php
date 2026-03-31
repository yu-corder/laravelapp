<div class="card">
    <div class="card-body">
        <input
        type="hidden"
        id="upload_token"
        name="upload_token"
        value="{{ old('upload_token', $uploadToken) }}">
        <div class="form-group mb-3">
            <label class="form-label">記事タイプ <span class="c-badge--required">必須</span></label>
            <select name="type" class="c-form__input @error('type') is-invalid @enderror">
                <option value="facility" {{ old('type', $content->type) == 'facility' ? 'selected' : '' }}>施設紹介</option>
                <option value="column" {{ old('type', $content->type) == 'column' ? 'selected' : '' }}>コラム</option>
                <option value="news" {{ old('type', $content->type) == 'news' ? 'selected' : '' }}>お知らせ</option>
            </select>
            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div id="sauna_select_group" class="form-group mb-3">
            <label class="form-label">紐づけるサウナ</label>
            <select name="sauna_id" class="c-form__input @error('sauna_id') is-invalid @enderror">
                <option value="">選択なし</option>
                @foreach($saunas as $sauna)
                    <option value="{{ $sauna->id }}" {{ old('sauna_id', $content->sauna_id) == $sauna->id ? 'selected' : '' }}>
                        {{ $sauna->name }}
                    </option>
                @endforeach
            </select>
            @error('sauna_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label">タイトル <span class="c-badge--required">必須</span></label>
            <input type="text" name="title" class="c-form__input @error('title') is-invalid @enderror"
                   value="{{ old('title', $content->title) }}" placeholder="記事のタイトルを入力">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label form-editor-label">本文 <span class="c-badge--required">必須</span></label>
            <textarea name="body" id="editor" class="@error('body') is-invalid @enderror">{{ old('body', $content->body) }}</textarea>
            @error('body') <div class="invalid-feedback text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group form-check form-switch mt-4">
            <input type="hidden" name="is_public" value="0">
            <input type="checkbox" name="is_public" class="form-check-input" id="is_public" value="1"
                   {{ old('is_public', $content->is_public) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_public">この記事を公開する</label>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/translations/ja.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const uploadToken = document.getElementById('upload_token').value;

        ClassicEditor
            .create(document.querySelector('#editor'), {
                language: 'ja',
                toolbar: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', 'link', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', 'imageUpload', 'undo', 'redo'],
                ckfinder: {
                    uploadUrl: `{{ route("admin.image.tmp.upload") }}?_token=${csrfToken}&upload_token=${uploadToken}`,
                }
            })
            .catch(error => { console.error(error); });
        const typeSelect = document.querySelector('select[name="type"]');
        const saunaGroup = document.getElementById('sauna_select_group');

        function toggleSaunaSelect() {
            saunaGroup.style.display = (typeSelect.value === 'facility') ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleSaunaSelect);
        toggleSaunaSelect();
    });
</script>
