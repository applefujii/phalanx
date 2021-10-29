<?php
/**
 * 適性診断フォームのコントローラー
 * 
 * @author Fumio Mochizuki
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AptitudeQuestion;
use Carbon\Carbon;

class AptitudeQuestionFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('category')->orderBy('sort')->get();
        return view('aptitude_question_form/index', compact('aptitude_questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request)
    {
        
        $question = $request->input('question');

        $aptitude_questions = AptitudeQuestion::select('score_apple', 'score_mint', 'score_maple')->whereNull('deleted_at')->orderBy('category')->orderBy('sort')->get();

        $result = 'apple';

        $total_score_apple = 0;
        $total_score_mint = 0;
        $total_score_maple = 0;

        // foreach ($aptitude_questions as $aptitude_question) {
        //     $total_score_apple += $aptitude_question->
        // }


        dd($aptitude_questions);



        
    }
}
