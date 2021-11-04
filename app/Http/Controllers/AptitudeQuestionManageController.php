<?php
/**
 * 適性診断質問管理のコントローラー
 * 
 * @author Fumio Mochizuki
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AptitudeQuestion;
use App\Http\Requests\AptitudeQuestionManageRequest;
use Carbon\Carbon;

class AptitudeQuestionManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('sort')->get();
        return view('aptitude_question_manage/index', compact('aptitude_questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aptitude_question_manage/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AptitudeQuestionManageRequest $request)
    {
        $now = Carbon::now();

        $aptitude_question = new AptitudeQuestion();
        $aptitude_question->question = $request->input('question');
        $aptitude_question->sort = $request->input('sort');
        $aptitude_question->score_apple = $request->input('score_apple');
        $aptitude_question->score_mint = $request->input('score_mint');
        $aptitude_question->score_maple = $request->input('score_maple');
        $aptitude_question->created_at = $now->isoFormat('YYYY-MM-DD');
        $aptitude_question->updated_at = $now->isoFormat('YYYY-MM-DD');
        $aptitude_question->save();

        return redirect()->route('aptitude_question_manage.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('sort')->get();
        return view('aptitude_question_manage/edit', compact('aptitude_questions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AptitudeQuestionManageRequest $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
