<?php
/**
 * 適性診断質問管理のコントローラー
 * 
 * @author Fumio Mochizuki
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AptitudeQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AptitudeQuestionManageCreateRequest;
use App\Http\Requests\AptitudeQuestionManageEditRequest;
use Carbon\Carbon;

class AptitudeQuestionManageController extends Controller
{
    // ログイン認証
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * 一覧画面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('sort')->get();
        return view('aptitude_question_manage/index', compact('aptitude_questions'));
    }

    /**
     * 新規登録画面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aptitude_question_manage/create');
    }

    /**
     * 新規登録画面の内容をDBに保存
     *
     * @param  \App\Http\Requests\AptitudeQuestionManageCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AptitudeQuestionManageCreateRequest $request)
    {
        $now = Carbon::now();

        $aptitude_question = new AptitudeQuestion();
        $aptitude_question->question = $request->input('question');
        $aptitude_question->sort = $request->input('sort');
        $aptitude_question->score_apple = $request->input('score_apple');
        $aptitude_question->score_mint = $request->input('score_mint');
        $aptitude_question->score_maple = $request->input('score_maple');
        $aptitude_question->create_user_id = Auth::user()->id;
        $aptitude_question->update_user_id = Auth::user()->id;
        $aptitude_question->created_at = $now->isoFormat('YYYY-MM-DD');
        $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD');
        $aptitude_question->save();

        return redirect()->route('aptitude_question_manage.index');
    }

    /**
     * 一括編集画面
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('sort')->get();
        return view('aptitude_question_manage/edit', compact('aptitude_questions'));
    }

    /**
     * 一括編集画面の内容をDBに保存
     *
     * @param  \App\Http\Requests\AptitudeQuestionManageEditRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(AptitudeQuestionManageEditRequest $request)
    {
        $now = Carbon::now();
        $questions = $request->input('questions');
        $sorts = $request->input('sorts');
        $score_apples = $request->input('score_apples');
        $score_mints = $request->input('score_mints');
        $score_maples = $request->input('score_maples');

        foreach ($questions as $id => $question) {
            $aptitude_question = AptitudeQuestion::findOrFail($id);
        
            $aptitude_question->question = $questions[$id];
            $aptitude_question->sort = $sorts[$id];
            $aptitude_question->score_apple = $score_apples[$id];
            $aptitude_question->score_mint = $score_mints[$id];
            $aptitude_question->score_maple = $score_maples[$id];
            $aptitude_question->update_user_id = Auth::user()->id;
            $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD');
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
        $aptitude_question->deleted_at = $now->isoFormat('YYYY-MM-DD');
        $aptitude_question->save();
        return redirect()->route('aptitude_question_manage.index');
    }
}
