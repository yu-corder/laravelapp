<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Item;

class ItemController extends Controller
{
    //商品一覧ページの表示
    public function index()
    {
        $items = Item::all();

        //index.blade.phpを返却
        return view("item.index", ['items' => $items]);
    }

    // 商品編集ページ
    public function showEdit($id)
    {

        $item = Item::find($id);

        return view('item.edit', ['item' => $item]);
    }

    // 商品編集の実行
    public function edit($id, Request $request)
    {
        $item = Item::find($id);

        $item->fill($request->all())->save();

        Log::info("編集が完了しました。");

        return redirect("/item");
    }

    // 商品登録ページ
    public function showAdd()
    {
        return view('item.add');
    }

    // 商品登録処理
    public function add(Request $request)
    {
        //フォームに入力した値の確認
        $item = new Item;

        $item->fill($request->all())->save();


        Log::info("登録が完了しました。");
        return view('item.add',
        [
            'message' => '登録が完了しました。',

        ]);
    }

    //商品削除
    public function delete($id)
    {
        $item = Item::find($id);

        $item->delete();

        Log::info("削除が完了しました。");


        return redirect("/item");
    }
}
