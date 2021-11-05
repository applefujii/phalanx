<?php
/**
 * 適性診断フォームのコントローラー
 * 
 * @author Fumio Mochizuki
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AptitudeQuestion;
use App\Http\Requests\AptitudeQuestionFormRequest;
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
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('sort')->get();
        return view('aptitude_question_form/index', compact('aptitude_questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculate(AptitudeQuestionFormRequest $request)
    {
        // dd($request->toArray());
        $answers = $request->input('answers');
        $score_apples = $request->input('score_apples');
        $score_mints = $request->input('score_mints');
        $score_maples = $request->input('score_maples');

        $total_score_apple = 0;
        $total_score_mint = 0;
        $total_score_maple = 0;
        $fixed = '';

        foreach ($answers as $id => $value) {
            if ($score_apples[$id] === 'F') {
                if ($value === "1") {
                    $fixed = 'apple';
                }
            }else if ($score_mints[$id] === 'F') {
                if ($value === "1") {
                    if ($fixed === '' || $fixed === 'maple') {
                        $fixed = 'mint';
                    }
                }
            }else if ($score_maples[$id] === 'F') {
                if ($value === "1") {
                    if ($fixed === '') {
                        $fixed = 'maple';
                    }
                }
            } else {
                $total_score_apple += $value * $score_apples[$id];
                $total_score_mint += $value * $score_mints[$id];
                $total_score_maple += $value * $score_maples[$id];
            }
        }

        logger("apple:" . $total_score_apple . " mint:" . $total_score_mint . " maple:" . $total_score_maple . " fixed:" . $fixed);

        if ($fixed === 'apple') {
            return redirect()->route('aptitude_question_form.apple');
        } else if ($fixed === 'mint') {
            return redirect()->route('aptitude_question_form.mint');
        } else if ($fixed === 'maple') {
            return redirect()->route('aptitude_question_form.maple');
            
        } else if ($total_score_maple > $total_score_mint && $total_score_maple > $total_score_apple) {
            return redirect()->route('aptitude_question_form.maple');
        } else if ($total_score_mint >= $total_score_maple && $total_score_mint > $total_score_apple) {
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
