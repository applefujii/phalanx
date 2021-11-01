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
        $score_apple = $request->input('score_apple');
        $score_mint = $request->input('score_mint');
        $score_maple = $request->input('score_maple');

        $total_score_apple = 0;
        $total_score_mint = 0;
        $total_score_maple = 0;

        foreach ($question as $id => $value) {
            $total_score_apple += $value * $score_apple[$id];
            $total_score_mint += $value * $score_mint[$id];
            $total_score_maple += $value * $score_maple[$id];
        }

        logger("apple:" . $total_score_apple . " mint:" . $total_score_mint . " maple:" . $total_score_maple);

        if ($total_score_maple > $total_score_mint && $total_score_maple > $total_score_apple) {
            return redirect()->route('aptitude_question_form.maple');
        } else if ($total_score_mint >= $total_score_apple) {
            return redirect()->route('aptitude_question_form.mint');
        } else {
            return redirect()->route('aptitude_question_form.apple');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apple()
    {
        return view('aptitude_question_form/result/apple');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mint()
    {
        return view('aptitude_question_form/result/mint');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function maple()
    {
        return view('aptitude_question_form/result/maple');
    }

}
