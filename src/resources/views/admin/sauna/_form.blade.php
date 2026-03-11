<input
    type="hidden"
    id="upload_token"
    name="upload_token"
    value="{{ old('upload_token', $uploadToken) }}">
<div class="form-group">
    <label for="addname">サウナ名<span class="c-badge--required">必須</span></label>
    <input
        class="c-form__input"
        type="text"
        name="name"
        id="addname"
        value="{{ old('name', $sauna->name ?? '') }}"
        placeholder="サウナ名を入力してください">
    @error('name')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-row">
    <div class="form-group">
        <label for="addpostcode">郵便番号<span class="c-badge--required">必須</span></label>
        <input
            class="c-form__input--short"
            id="addpostcode"
            type="number"
            name="postcode"
            value="{{ old('postcode', $sauna->postcode ?? '') }}"
            placeholder="郵便番号を入力してください">
        @error('postcode')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="addprefecture">都道府県<span class="c-badge--required">必須</span></label>
        <input
            class="c-form__input--short"
            id="addprefecture"
            type="text"
            name="prefecture"
            value="{{ old('prefecture', $sauna->prefecture ?? '') }}"
            placeholder="都道府県を入力してください">
        @error('prefecture')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label for="addcity">市区町村<span class="c-badge--required">必須</span></label>
        <input
            class="c-form__input--short"
            id="addcity"
            type="text"
            name="city"
            value="{{ old('city', $sauna->city ?? '') }}"
            placeholder="市区町村を入力してください">
        @error('city')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="addaddress">それ以降の住所<span class="c-badge--required">必須</span></label>
        <input
            class="c-form__input--short"
            id="addaddress"
            type="text"
            name="address"
            value="{{ old('address', $sauna->address ?? '') }}"
            placeholder="市区町村以降を入力してください">
        @error('address')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label for="addsauna_temp">サウナ温度</label>
        <input
            class="c-form__input"
            id="addsauna_temp"
            type="number"
            name="sauna_temp"
            value="{{ old('sauna_temp', $sauna->sauna_temp ?? '') }}"
            placeholder="サウナ温度">
    </div>
    <div class="form-group">
        <label for="addwater_temp">水風呂温度</label>
        <input
            class="c-form__input"
            id="addwater_temp"
            type="number"
            name="water_temp"
            value="{{ old('water_temp', $sauna->water_temp ?? '') }}"
            placeholder="水風呂温度">
    </div>
</div>
<div class="form-row">
    <div class="form-group">
        <label for="addprice">平日料金（円）</label>
        <input
            class="c-form__input--short"
            id="addprice"
            type="number"
            name="price"
            value="{{ old('price', $sauna->price ?? '') }}"
            placeholder="例: 800">
        @error('price')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="addweekend_price">休日料金（円）</label>
        <input
            class="c-form__input--short"
            id="addweekend_price"
            type="number"
            name="weekend_price"
            value="{{ old('weekend_price', $sauna->weekend_price ?? '') }}"
            placeholder="例: 1000">
        @error('weekend_price')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-group">
    <label for="addhas_loyly">ロウリュウ有無<span class="c-badge--required">必須</span></label>
    <select name="has_loyly" id="addhas_loyly" class="c-form__input">
        <option value="">--1 つ選択してください--</option>
        <option value="0" {{ old('has_loyly', $sauna->has_loyly ?? '') == '0' ? 'selected' : '' }}>無し</option>
        <option value="1" {{ old('has_loyly', $sauna->has_loyly ?? '') == '1' ? 'selected' : '' }}>有り</option>
    </select>
    @error('has_loyly')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="adddescription">コメント</label>
    <textarea class="c-form__input" id="adddescription" name="description" placeholder="コメントを入力してください">
        {{ old('description', $sauna->description ?? '') }}
    </textarea>
    @error('description')
        <div>{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="sauna_image">サウナ画像</label>
    <input
        type="file"
        id="sauna_image"
        class="c-form__input"
        accept="image/*"
        data-url="{{ route('admin.sauna.upload_tmp') }}"
        name="sauna_img"
        onchange="uploadImg(this);"
    >
    <div id="image_preview_container" style="display: flex; gap: 10px; margin-top: 10px;">
    </div>
</div>

<h2 class="form-section-title">サウナ評価（5段階）</h2>

<div class="form-row form-sauna-rating">
    <div class="form-group from-sauna-rating-group">
        <label for="addcost_performance">コスパ<span class="c-badge--required">必須</span></label>
        <select name="cost_performance" id="addcost_performance" class="c-form__input--short @error('cost_performance') is-invalid @enderror">
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('cost_performance', $sauna->rating->cost_performance ?? 3) == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @error('cost_performance')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group from-sauna-rating-group">
        <label for="addaccessibility">アクセス<span class="c-badge--required">必須</span></label>
        <select name="accessibility" id="addaccessibility" class="c-form__input--short @error('accessibility') is-invalid @enderror">
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('accessibility', $sauna->rating->accessibility ?? 3) == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @error('accessibility')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-row form-sauna-rating">
    <div class="form-group">
        <label for="addcomfortability">快適度<span class="c-badge--required">必須</span></label>
        <select name="comfortability" id="addcomfortability" class="c-form__input--short @error('comfortability') is-invalid @enderror">
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('comfortability', $sauna->rating->comfortability ?? 3) == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @error('comfortability')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="addtotonoi_score">ととのい度<span class="c-badge--required">必須</span></label>
        <select name="totonoi_score" id="addtotonoi_score" class="c-form__input--short @error('totonoi_score') is-invalid @enderror">
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ old('totonoi_score', $sauna->rating->totonoi_score ?? 3) == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @error('totonoi_score')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>
