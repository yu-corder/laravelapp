<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Sauna;
use App\Models\Content;
use App\Http\Requests\Admin\ContentRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * 一覧ページ
     */
    public function index()
    {
        // 施設名も表示できるようリレーションをロード
        $contents = Content::with('sauna')->get();
        return view("admin.content.index", compact('contents'));
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
        $content = $id ? Content::findOrFail($id) : new Content;
        $saunas = Sauna::all(); // 紐付け対象の選択肢
        $uploadToken = Str::random(32);
        // 既存の命名規則に合わせる
        $view = $id ? 'admin.content.edit' : 'admin.content.add';

        return view($view, compact('content', 'saunas', 'uploadToken'));
    }

    /**
     * 更新処理
     */
    public function edit($id, ContentRequest $request)
    {
        return $this->store($request, $id);
    }

    /**
     * 登録処理
     */
    public function add(ContentRequest $request)
    {
        return $this->store($request);
    }

    /**
     * 登録・更新の共通処理
     */
    private function store(ContentRequest $request, $id = null)
    {
        DB::transaction(function () use ($request, $id) {
            $content = $id ? Content::findOrFail($id) : new Content;

            // バリデーション済みデータを反映
            $content->fill($request->validated());

            // 公開フラグの調整（チェックボックス対策）
            $content->is_public = $request['is_public'];

            $content->save();

            $movedImages = Image::moveFromTmp($request->upload_token, $content);

            if (!empty($movedImages)) {
                $newBody = $content->body;
                foreach ($movedImages as $image) {
                    $newBody = str_replace($image['old_url'], $image['new_url'], $newBody);
                }
                $content->body = $newBody;
                $content->save();
            }
        });

        $message = $id ? 'コンテンツの編集が完了しました' : 'コンテンツの登録が完了しました';
        Log::info($message);

        return redirect("/admin/contents")->with('success', $message);
    }

    /**
     * 削除
     */
    public function delete($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();
        Log::info("コンテンツの削除が完了しました。");
        return redirect("/admin/contents")->with('success', '削除が完了しました');
    }
}
