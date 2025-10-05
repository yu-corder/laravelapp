<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品登録ページ</title>
    </head>
    <body>
        <h1>商品登録ページ</h1>
        <form action="{{ url('item/add') }}" method="post">
            @csrf
            <div>
                <label for="addname">商品名</label>
                <input type="text" name="name" id="addname">
            </div>
            <div>
                <input type="number" name="price">
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
