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
     * 質問フォーム画面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aptitude_questions = AptitudeQuestion::whereNull('deleted_at')->orderBy('sort')->get();
        return view('aptitude_question_form/index', compact('aptitude_questions'));
    }

    /**
     * 回答を集計して結果を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function calculate(AptitudeQuestionFormRequest $request)
    {
        // dd($request->toArray());
        $aptitude_questions = $request->input('aptitude_questions');

        // 各事業所の合計点数
        $total_score_apple = 0;
        $total_score_mint = 0;
        $total_score_maple = 0;
        // 確定質問で確定された対象の事業所
        $fixed = '';

        foreach ($aptitude_questions as $aptitude_question) {
            if ($aptitude_question['score_apple'] === 'F') {
                if ($aptitude_question['answer'] === "1") {
                    $fixed = 'apple';
                }
            }else if ($aptitude_question['score_mint'] === 'F') {
                if ($aptitude_question['answer'] === "1") {
                    if ($fixed === '' || $fixed === 'maple') {
                        $fixed = 'mint';
                    }
                }
            }else if ($aptitude_question['score_maple'] === 'F') {
                if ($aptitude_question['answer'] === "1") {
                    if ($fixed === '') {
                        $fixed = 'maple';
                    }
                }
            } else {
                $total_score_apple += $aptitude_question['answer'] * $aptitude_question['score_apple'];
                $total_score_mint += $aptitude_question['answer'] * $aptitude_question['score_mint'];
                $total_score_maple += $aptitude_question['answer'] * $aptitude_question['score_maple'];
            }
        }

        logger("apple:" . $total_score_apple . " mint:" . $total_score_mint . " maple:" . $total_score_maple . " fixed:" . $fixed);

        if (!empty($fixed)) {
            if ($fixed === 'maple') {
                return redirect()->route('aptitude_question_form.maple');
            } else if ($fixed === 'mint') {
                return redirect()->route('aptitude_question_form.mint');
            } else {
                return redirect()->route('aptitude_question_form.apple');
            }
        } else if ($total_score_maple > $total_score_mint && $total_score_maple > $total_score_apple) {
            return redirect()->route('aptitude_question_form.maple');
        } else if ($total_score_mint >= $total_score_maple && $total_score_mint > $total_score_apple) {
            return redirect()->route('aptitude_question_form.mint');
        } else {
            return redirect()->route('aptitude_question_form.apple');
        }
    }

    /**
     * アップル梅田
     *
     * @return \Illuminate\Http\Response
     */
    public function apple()
    {
        return view('aptitude_question_form/result/apple');
    }

    /**
     * ミント大阪
     *
     * @return \Illuminate\Http\Response
     */
    public function mint()
    {
        return view('aptitude_question_form/result/mint');
    }

    /**
     * メープル関西
     *
     * @return \Illuminate\Http\Response
     */
    public function maple()
    {
        return view('aptitude_question_form/result/maple');
    }

}
