<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Sauna;
use App\Models\Rating;
use App\Models\SaunaImage;
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
        return $this->renderView($id);
    }

    //サウナ登録ページ
    public function showAdd()
    {
        return $this->renderView();
    }

    private function renderView($id = null)
    {
        $sauna = $id ? Sauna::with('images')->findOrFail($id) : new Sauna;
        $uploadToken = Str::random(32);
        $view = $id ? 'admin.sauna.edit' : 'admin.sauna.add';
        return view($view, compact('sauna', 'uploadToken'));
    }

    //サウナ編集の実行
    public function edit($id, SaunaRequest $request)
    {
        DB::transaction(function () use ($id, $request) {
            $sauna = Sauna::find($id);

            $sauna->fill($request->validated())->save();

            $sauna->rating()->updateOrCreate(
                ['sauna_id' => $sauna->id],
                [
                    'cost_performance' => $request->cost_performance,
                    'accessibility'    => $request->accessibility,
                    'comfortability'   => $request->comfortability,
                    'totonoi_score'    => $request->totonoi_score,
                ]
            );

            SaunaImage::createFromTmpToken($sauna->id, $request->upload_token);
        });

        Log::info("編集が完了しました。");

        return redirect("/admin/sauna")->with('success', '編集が完了しました');
    }

    //サウナ登録処理
    public function add(SaunaRequest $request)
    {
        try {
            //フォームに入力した値の確認
            DB::transaction(function () use ($request) {
                $sauna = new Sauna;
                $sauna->fill($request->all())->save();
                $sauna->rating()->create([
                    'cost_performance' => $request->cost_performance,
                    'accessibility'    => $request->accessibility,
                    'comfortability'   => $request->comfortability,
                    'totonoi_score'    => $request->totonoi_score,
                ]);

                SaunaImage::createFromTmpToken($sauna->id, $request->upload_token);
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
}
