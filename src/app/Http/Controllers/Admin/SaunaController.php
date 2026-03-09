<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Sauna;
use App\Models\Rating;
use App\Http\Requests\Admin\SaunaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class SaunaController extends Controller
{
    //商品一覧ページの表示
    public function index()
    {
        // DBから全件取得
        $saunas = Sauna::all();
        //index.blade.phpを返却
        return view("admin.sauna.index", compact('saunas'));
    }

    //サウナ編集ページ
    public function showEdit($id)
    {

        $sauna = Sauna::find($id);

        return view('admin.sauna.edit', ['sauna' => $sauna]);
    }

    //サウナ編集の実行
    public function edit($id, SaunaRequest $request)
    {
        DB::transaction(function () use ($id, $request) {
            $sauna = Sauna::find($id);

            $sauna->fill($request->validated())->save();

            // 2. 評価データの更新（なければ作成）
            $sauna->rating()->updateOrCreate(
                ['sauna_id' => $sauna->id],
                [
                    'cost_performance' => $request->cost_performance,
                    'accessibility'    => $request->accessibility,
                    'comfortability'   => $request->comfortability,
                    'totonoi_score'    => $request->totonoi_score,
                ]
            );
        });

        Log::info("編集が完了しました。");

        return redirect("/admin/sauna");
    }

    //サウナ登録ページ
    public function showAdd()
    {
        $uploadToken = Str::random(32);
        return view('admin.sauna.add', compact('uploadToken'));
    }

    //サウナ登録処理
    public function add(SaunaRequest $request)
    {
        try {
            //フォームに入力した値の確認
            DB::transaction(function () use ($request) {
                $sauna = new Sauna;

                $sauna->fill($request->all())->save();

                // 2. 評価データの登録
                $sauna->rating()->create([
                    'cost_performance' => $request->cost_performance,
                    'accessibility'    => $request->accessibility,
                    'comfortability'   => $request->comfortability,
                    'totonoi_score'    => $request->totonoi_score,
                ]);

                $tmpImages = DB::table('tmp_sauna_images')
                    ->where('upload_token', $request->upload_token)
                    ->get();

                foreach ($tmpImages as $tmpImage) {
                    $newPath = str_replace('public/tmp/', 'public/saunas/', $tmpImage->path);
                    Storage::move($tmpImage->path, $newPath);
                    DB::table('sauna_images')->insert([
                        'sauna_id' => $sauna->id,
                        'path' => $newPath,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('tmp_sauna_images')
                    ->where('upload_token', $request->upload_token)
                    ->delete();
            });

            Log::info("登録が完了しました。");
            return redirect("/admin/sauna")->with('success', '登録しました');
        } catch (\Exception $e) {
            return back()->withInput();
        }
    }

    //サウナ削除
    public function delete($id)
    {
        $sauna = Sauna::find($id);

        $sauna->delete();

        Log::info("削除が完了しました。");


        return redirect("/admin/sauna");
    }

    public function upload(Request $request)
    {
        // バリデーション
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'upload_token' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('public/tmp'); // 'public/tmp/ランダム名.jpg' で保存される

            DB::table('tmp_sauna_images')->insert([
                'upload_token' => $request->upload_token,
                'path' => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'path' => $path,
                'url' => Storage::url($path), // ブラウザ表示用のURL
                'msg' => '画像を一時保存しました',
            ]);
        }

        return response()->json(['status' => 'error', 'msg' => 'アップロード失敗'], 400);
    }

}
