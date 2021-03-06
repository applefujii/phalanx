<?php
/**
 * 適性診断質問管理のコントローラー
 *
 * @author Fumio Mochizuki
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AptitudeQuestion;
use App\Models\Office;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AptitudeQuestionManageRequest;
use App\Http\Requests\AptitudeQuestionManageAllRequest;
use Carbon\Carbon;

class AptitudeQuestionManageController extends Controller
{
    // 権限チェック
    public function __construct()
    {
        $this->middleware('staff');// 職員
    }

    /**
     * 一覧画面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aptitude_questions = AptitudeQuestion::
            with('scores.office')
            ->whereNull('deleted_at')
            ->orderBy('sort')
            ->get();
        $offices = Office::select("office_name")->whereNull('deleted_at')->orderBy('sort')->get();
        return view('aptitude_question_manage/index', compact('aptitude_questions', 'offices'));
    }

    /**
     * 新規登録画面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offices = Office::whereNull('deleted_at')->orderBy('id')->get();
        return view('aptitude_question_manage/create', compact('offices'));
    }

    /**
     * 新規登録画面の内容をDBに保存
     *
     * @param  AptitudeQuestionManageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AptitudeQuestionManageRequest $request)
    {
        $now = Carbon::now();
        $aptitude_question = new AptitudeQuestion;
        $aptitude_question->question = $request->input('question');
        $aptitude_question->sort = $request->input('sort');
        $aptitude_question->update_user_id = Auth::user()->id;
        $aptitude_question->created_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $aptitude_question->save();

        foreach ($request->input('scores') as $input_value_score) {
            $score = new Score;
            $score->aptitude_question_id = $aptitude_question->id;
            $score->office_id = $input_value_score['office_id'];
            $score->score = $input_value_score['score'];
            $score->update_user_id = Auth::user()->id;
            $score->created_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $score->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $score->save();
        }

        return redirect()->route('aptitude_question_manage.index');
    }

    /**
     * 一括編集画面
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_all()
    {
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('sort')->get();
        $offices = Office::whereNull('deleted_at')->orderBy("sort")->get();
        return view('aptitude_question_manage/edit_all', compact('aptitude_questions', 'offices'));
    }

    /**
     * 一括編集画面の内容をDBに保存
     *
     * @param  \App\Http\Requests\AptitudeQuestionManageAllRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update_all(AptitudeQuestionManageAllRequest $request)
    {
        $now = Carbon::now();
        $aptitude_questions = $request->input('aptitude_questions');

        foreach ($aptitude_questions as $input_value_aptitude_question) {
            $aptitude_question = AptitudeQuestion::findOrFail($input_value_aptitude_question['id']);
            $aptitude_question->question = $input_value_aptitude_question['question'];
            $aptitude_question->sort = $input_value_aptitude_question['sort'];
            $aptitude_question->update_user_id = Auth::user()->id;
            $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $aptitude_question->save();


            foreach ($input_value_aptitude_question['score'] as $input_value_score) {
                $score = Score::findOrFail($input_value_score['id']);
                $score->score = $input_value_score['score'];
                $score->update_user_id = Auth::user()->id;
                $score->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
                $score->save();
            }
        }
        return redirect()->route('aptitude_question_manage.index');
    }

    /**
     * 質問をDBから削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $now = Carbon::now();
        $aptitude_question = AptitudeQuestion::findOrFail($id);

        $aptitude_question->update_user_id = Auth::user()->id;
        $aptitude_question->delete_user_id = Auth::user()->id;
        $aptitude_question->deleted_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $aptitude_question->save();

        foreach ($aptitude_question->scores as $delete_score) {
            $score = Score::findOrFail($delete_score->id);
            $score->update_user_id = Auth::user()->id;
            $score->delete_user_id = Auth::user()->id;
            $score->deleted_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $score->save();
        }
        return redirect()->route('aptitude_question_manage.index');
    }
}
