<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品編集ページ</title>
    </head>
    <body>
        <h1>商品編集ページ</h1>
        <form action="/item/edit/{{ $item->id }}" method="post">
            @csrf
            <div>
                <label for="addname">商品名</label>
                <input type="text" name="name" id="addname" value="{{ $item->name }}">
            </div>
            <div>
                <input type="number" name="price" value="{{ $item->price }}">
            </div>
            <div>
                <input type="submit" name="send" value="登録">
            </div>
        </form>

        @if (isset($message))
        <p>{{ $message }}</p>
        @endif
    </body>
</html>
