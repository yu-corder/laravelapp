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
            ->get()
            ->keyBy('visit_date');

        $prevMonth = $currentDate->copy()->subMonth()->format('Y-m');
        $nextMonth = $currentDate->copy()->addMonth()->format('Y-m');

        return view('admin.totonoi_history.index', compact('currentMonth', 'daysInMonth', 'firstDayOfWeek', 'histories', 'prevMonth', 'nextMonth', 'currentDate'));
    }

    /**
     * サ活登録ページ
     */
    public function showAdd(Request $request)
    {
        if ($request->ajax()) {

            $saunas = Sauna::all();
            $html = view('admin.totonoi_history._form', compact('saunas'))->render();

            return response()->json([
                'status' => 'success',
                'html' => $html,
            ]);
        }
    }

    /**
     * サ活登録
     */
    public function add(TotonoiHistoryRequest $request)
    {
        $totonoiHistory = new TotonoiHistory;
        $totonoiHistory->fill($request->all())->save();

        $visitDate = Carbon::parse($request->input('visit_date'));
        $monthParam = $visitDate->format('Y-m');

        Log::info("登録が完了しました。");
        return redirect()->route('admin.totonoi_history.index', ['month' => $monthParam]);
    }
}
