<?php
/**
 * 適性診断フォームのコントローラー
 *
 * @author Fumio Mochizuki
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AptitudeQuestion;
use App\Models\Office;
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
        $aptitude_answers = $request->input('aptitude_questions');
        $aptitude_questions = AptitudeQuestion::select('scores')->whereNull('deleted_at')->orderBy('sort')->get();
        // 同点の場合はこのソート順で登録される
        $offices = Office::select("en_office_name")->whereNull('deleted_at')->orderBy('sort')->get();

        // 各事業所の合計点数
        $total_score = array_fill(0, count($offices), 0);


        for( $i=0 ; $i<count($aptitude_answers) ; $i++) {
            $answer = $aptitude_answers[$i+1]["answer"];
            $scores = explode(",", $aptitude_questions[$i]["scores"]);

            foreach($scores as $index => $score) {
                if($score == "F") {
                    if($answer == 1) $total_score[$index] +=999999;
                    else if($answer == -1) $total_score[$index] -=999999;
                }
                else $total_score[$index] += $score * $answer;
            }
        }
        dd($total_score);

        // foreach($total_score as $index => $ts) {
        //     logger($index." / ".$ts);
        // }

        $max = max($total_score);
        foreach($total_score as $index => $sc) {
            if($sc == $max) {
                return redirect()->route('aptitude_question_form.' . $offices[$index]["en_office_name"]);
            }
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

    /**
     * アボカドジャパン
     *
     * @return \Illuminate\Http\Response
     */
    public function abokado()
    {
        return view('aptitude_question_form/result/abokado');
    }

    /**
     * バナナワールド
     *
     * @return \Illuminate\Http\Response
     */
    public function banana()
    {
        return view('aptitude_question_form/result/banana');
    }

}
