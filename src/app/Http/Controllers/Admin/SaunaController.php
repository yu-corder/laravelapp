<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Sauna;
use App\Models\Rating;
use App\Models\Image;
use App\Http\Requests\Admin\SaunaRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class SaunaController extends Controller
{
    /**
     * 一覧ページ
     */
    public function index()
    {
        $saunas = Sauna::all();
        return view("admin.sauna.index", compact('saunas'));
    }

    /**
     * 更新ページ
     */
    public function showEdit($id)
    {
        return $this->renderView($id);
    }

    /**
     * 登録ページ
     */
    public function showAdd()
    {
        return $this->renderView();
    }

    /**
     * 登録・更新ページの共通処理
     */
    private function renderView($id = null)
    {
        $sauna = $id ? Sauna::with('images')->findOrFail($id) : new Sauna;
        $uploadToken = Str::random(32);
        $view = $id ? 'admin.sauna.edit' : 'admin.sauna.add';
        return view($view, compact('sauna', 'uploadToken'));
    }

    /**
     * 更新の共通処理
     */
    public function edit($id, SaunaRequest $request)
    {
        return $this->store($request, $id);
    }

    /**
     * 登録
     */
    public function add(SaunaRequest $request)
    {
        return $this->store($request);
    }

    /**
     * 登録・更新の共通処理
     */
    private function store(SaunaRequest $request, $id = null)
    {
        DB::transaction(function () use ($request, $id) {
            $sauna = $id ? Sauna::findOrFail($id) : new Sauna;
            $sauna->fill($request->validated())->save();
            $sauna->rating()->updateOrCreate(
                ['sauna_id' => $sauna->id],
                $request->only(['cost_performance', 'accessibility', 'comfortability', 'totonoi_score'])
            );
            Image::moveFromTmp($request->upload_token, $sauna);
        });

        $message = $id ? '編集が完了しました' : '登録が完了しました';
        Log::info($message);

        return redirect("/admin/sauna")->with('success', $message);
    }

    /**
     * 削除
     */
    public function delete($id)
    {
        $sauna = Sauna::find($id);
        $sauna->delete();
        Log::info("削除が完了しました。");
        return redirect("/admin/sauna");
    }
}
