<?php

namespace App\Http\Controllers\User;

use App\Admin\Category;
use App\Admin\QuizModel;
use App\Admin\SubCategory;
use App\Quiz\QuizResult;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserQuizController extends Controller
{
    public function dashboard()
    {
        $user_q = User::find(Auth::user()->id)->quiz_results;
        $user_name = Auth::user()->name;
        return view('user.user_dashboard', compact('user_q','user_name'));
    }
    public function index(Request $request)
    {
        $this->validate($request, [
            'subcategory_id' => 'required|not_in:default',
        ]);
        $data = SubCategory::findOrFail($request->subcategory_id)->quizModels;
//        $data = $data->shuffle()->take(2);
        $j = 0;
        $subcat_id = $request->subcategory_id;
        return view('user.quiz_form')->with(compact('data', 'j', 'subcat_id'));
    }

    public function result(Request $request)
    {
        $subcat = SubCategory::findOrFail($request->subcat_id);
        $user_quiz = SubCategory::findOrFail($request->subcat_id)->quizModels;
        $total_questions = count($user_quiz);
        $correct_answers = 0;
        $wrong_answers = 0;
        $result = 0;
        for ($i = 0; $i < count($user_quiz); $i++) {
            if ($user_quiz[$i]['type'] == 1) {
                if ($request->radio) {
                    if (isset($request->radio[$user_quiz[$i]['id']])) {
                        $quiz_ans = QuizModel::findOrFail($user_quiz[$i]['id'])->answerModels->toArray();
                        $ans = $quiz_ans[0]['answer_desc'];
                        if ($ans == $request->radio[$user_quiz[$i]['id']]) {
                            $result += 5;
                            $correct_answers++;
                        } else {
                            $wrong_answers++;
                        }
                    } else {
                        $wrong_answers++;
                    }
                } else {
                    $wrong_answers++;
                }
            }
            if ($user_quiz[$i]['type'] == 2) {
                if ($request->check) {
                    if (isset($request->check[$user_quiz[$i]['id']])) {
                        $quiz_ans = QuizModel::findOrFail($user_quiz[$i]['id'])->answerModels->toArray();
                        $count = 0;
                        $checkbox_count = 0;
                        for ($j = 0; $j < count($quiz_ans); $j++) {
                            if ($quiz_ans[$j]['answer_desc'] != 'empty') {
                                $count++;
                            }
                        }
                        for ($k = 0; $k < 4; $k++) {
                            if (isset($request->check[$user_quiz[$i]['id']][$k])) //return checkbox value
                            {
                                if ($quiz_ans[$k]['answer_desc'] == $request->check[$user_quiz[$i]['id']][$k]) {
                                    $checkbox_count++;
                                } else {
                                    $checkbox_count--;
                                }
                            }
                        }
                        if ($count == $checkbox_count) {
                            $result += 5;
                            $correct_answers++;
                        } else {
                            $wrong_answers++;
                        }
                    } else {
                        $wrong_answers++;
                    }
                } else {
                    $wrong_answers++;
                }
            }
        }
        $persentage = round(($correct_answers/$total_questions)*100);
        $qresult = new QuizResult;
        $qresult->quiz_subcategory = $subcat->title;
        $qresult->total_questions = $total_questions;
        $qresult->correct_answers = $correct_answers;
        $qresult->wrong_answers = $wrong_answers;
        $qresult->	persentage = $persentage;
        $qresult->save();
        $r_id = $qresult->id;
        $u_id = Auth::user()->id;
        DB::table('quiz_result_user')->insert(['user_id'=>$u_id,'quiz_result_id'=>$r_id]);
        return response()->json(
            [
                'view' => view('user.quiz_result', compact('result', 'correct_answers', 'wrong_answers','persentage'))->render(),
            ]
        );
    }

}

