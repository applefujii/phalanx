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
        $aptitude_questions = AptitudeQuestion::with('scores.office')->whereNull('deleted_at')->orderBy('sort')->get();
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
        $offices = Office::select("office_name")->whereNull('deleted_at')->orderBy('id')->get();
        return view('aptitude_question_manage/create', compact('offices'));
    }

    /**
     * 新規登録画面の内容をDBに保存
     *
     * @param  \App\Http\Requests\AptitudeQuestionManageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AptitudeQuestionManageRequest $request)
    {
        $now = Carbon::now();
        $scores = implode(",", $request->scores);
        $aptitude_question = new AptitudeQuestion();
        $aptitude_question->question = $request->input('question');
        $aptitude_question->sort = $request->input('sort');
        $aptitude_question->scores = $scores;
        $aptitude_question->create_user_id = Auth::user()->id;
        $aptitude_question->update_user_id = Auth::user()->id;
        $aptitude_question->created_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $aptitude_question->save();

        return redirect()->route('aptitude_question_manage.index');
    }

    /**
     * 編集画面
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aptitude_question = AptitudeQuestion::whereNull('deleted_at')->findOrFail($id);
        $offices = Office::select("office_name", "en_office_name")->whereNull('deleted_at')->orderBy('id')->get();
        return view('aptitude_question_manage/edit', compact('aptitude_question', 'offices'));
    }

    /**
     * 編集画面の内容をDBに保存
     *
     * @param  \App\Http\Requests\AptitudeQuestionManageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(AptitudeQuestionManageRequest $request, $id)
    {
        $now = Carbon::now();
        $aptitude_question = AptitudeQuestion::findOrFail($id);
        $scores = implode(",", $request->scores);

        $aptitude_question->question = $request->input('question');
        $aptitude_question->sort = $request->input('sort');
        $aptitude_question->scores = $scores;
        $aptitude_question->update_user_id = Auth::user()->id;
        $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
        $aptitude_question->save();

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

        foreach ($aptitude_questions as $input_value) {
            $scores = implode(",", $input_value["scores"]);
            $aptitude_question = AptitudeQuestion::findOrFail($input_value['id']);

            $aptitude_question->question = $input_value['question'];
            $aptitude_question->sort = $input_value['sort'];
            $aptitude_question->scores = $scores;
            $aptitude_question->update_user_id = Auth::user()->id;
            $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD HH:mm:ss');
            $aptitude_question->save();
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
        return redirect()->route('aptitude_question_manage.index');
    }
}
