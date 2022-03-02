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
use App\Models\Score;
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

        $offices = Office::whereNull('deleted_at')->orderBy('priority')->get();
        $aptitude_questions = AptitudeQuestion::with('scores')->whereNull('deleted_at')->get();

        // 各事業所の合計点数
        $total_scores = [];
        $office_score = 0;

        foreach ($offices as $office) {
            data_set($total_scores, $office->id . '.office_id', $office->id);
            data_set($total_scores, $office->id . '.en_office_name', $office->en_office_name);
            foreach($aptitude_questions as $aptitude_question) {
                $office_score = data_get($total_scores, $office->id . '.score') ?? 0;
                $score = Score::whereNull('deleted_at')->where('office_id', $office->id)->where('aptitude_question_id', $aptitude_question->id)->first()->score ?? 0;
                $office_score += $answers[$aptitude_question->id]['answer'] * $score;
                data_set($total_scores, $office->id . '.score', $office_score);
            }
        }

        $max_office_id = $offices->first()->id;
        $max_score = $total_scores[$max_office_id]['score'];
        foreach($total_scores as $total_score) {
            if ($total_score['score'] > $max_score) {
                $max_score = $total_score['score'];
                $max_office_id = $total_score['office_id'];
            }
        }

        $matched_office = $offices->where('id', $max_office_id)->first();

        return redirect()->route('aptitude_question_form.result', $max_office_id);
    }

    /**
     * 結果画面
     *
     * @return \Illuminate\Http\Response
     */
    public function result($max_office_id)
    {
        $office = Office::whereNull('deleted_at')->findOrFail($max_office_id);
        return view('aptitude_question_form/result/index', compact('office'));
    }

}
