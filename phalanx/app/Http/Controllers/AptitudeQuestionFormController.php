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
        $answers = $request->input('answers');
        // dd($answers);

        $offices = Office::whereNull('deleted_at')->get();
        $aptitude_questions = AptitudeQuestion::with('scores')->whereNull('deleted_at')->get();

        // 各事業所の合計点数
        $total_score = [];

        foreach ($offices as $office) {
            data_set($total_score, $office->id . '.office_id', $office->id);
        }

        foreach($answers as $answer) {
            foreach ($offices as $office) {
                dd($aptitude_questions->where('id', $answer['id'])->where('')->toArray());
                $score = data_get($total_score, $office->id . '.score', 1);
                $score += $answer['answer'] * $aptitude_questions->where('id', $answer['id']);
                data_set($total_score, $office->id . '.score', $a);
            }
        }
        data_set($total_score, $office->id . '.score', $office->id);

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

}
