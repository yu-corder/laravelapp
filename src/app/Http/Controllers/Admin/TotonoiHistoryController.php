<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TotonoiHistoryRequest;
use App\Models\Sauna;
use App\Models\TotonoiHistory;
use Carbon\Carbon;



class TotonoiHistoryController extends Controller
{
    /**
     * 一覧ページ
     */
    public function index(Request $request)
    {
        $monthParam = $request->query('month', now()->format('Y-m'));
        $currentDate = \Carbon\Carbon::parse($monthParam . '-01');
        $currentMonth = \Carbon\Carbon::parse($monthParam)->startOfMonth();

        $daysInMonth = $currentMonth->daysInMonth;
        $firstDayOfWeek = $currentMonth->dayOfWeek;

        $histories = TotonoiHistory::with('sauna')
            ->whereYear('visit_date', $currentMonth->year)
            ->whereMonth('visit_date', $currentMonth->month)
            ->get();

        $totalPrice = $histories->sum('price');
        $histories = $histories->groupBy('visit_date');

        $prevMonth = $currentDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentDate->copy()->addMonth()->format('Y-m');

        return view('admin.totonoi_history.index', compact('currentMonth', 'daysInMonth', 'firstDayOfWeek', 'histories', 'prevMonth', 'nextMonth', 'currentDate', 'totalPrice'));
    }

    /**
     * フォーム取得 (Ajax) - showAdd, showEdit 両対応
     */
    private function getForm($id = null)
    {
        $history = $id ? TotonoiHistory::findOrFail($id) : null;
        $saunas = Sauna::all();

        $html = view('admin.totonoi_history._form', compact('history', 'saunas'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    /**
     * 保存処理(登録・更新)
     */
    private function store(TotonoiHistoryRequest $request, $id = null)
    {
        $history = $id ? TotonoiHistory::findOrFail($id) : new TotonoiHistory;

        $history->fill($request->validated())->save();

        $monthParam = Carbon::parse($history->visit_date)->format('Y-m');
        $message = $id ? "サ活を更新しました" : "登録が完了しました";

        Log::info($message . "（ID: {$history->id}）");

        return redirect()
            ->route('admin.totonoi_history.index', ['month' => $monthParam])
            ->with('success', $message);
    }

    /**
     * サ活登録ページ
     */
    public function showAdd(Request $request)
    {
        return $this->getForm();
    }

    /**
     * サ活登録
     */
    public function add(TotonoiHistoryRequest $request)
    {
        return $this->store($request);
    }

    /**
     * 編集フォームの取得 (Ajax)
     */
    public function showEdit($id)
    {
        return $this->getForm($id);
    }

    /**
     * サ活編集
     */
    public function edit($id, TotonoiHistoryRequest $request)
    {
        return $this->store($request, $id);
    }

    /**
     * サ活削除
     */
    public function delete($id)
    {
        $history = TotonoiHistory::findOrFail($id);
        $month = \Carbon\Carbon::parse($history->visit_date)->format('Y-m');

        $history->delete();

        Log::info("サ活を削除しました（ID: {$id}）");

        return redirect()->route('admin.totonoi_history.index', ['month' => $month])->with('success', '削除しました');
    }
}
