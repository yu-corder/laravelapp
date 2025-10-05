<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>商品一覧表示ページ</title>
    </head>
    <body>
        <h1>商品一覧表示ページ</h1>

        <table>
            <thead>
                <tr>
                    <td>id</td>
                    <td>商品名</td>
                    <td>価格</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->price) }}</td>
                        <td>
                            <form action="/item/delete/{{ $item->id }}" method="post">
                                @csrf
                                <input type="submit" value="削除">
                            </form>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </body>
</html>
