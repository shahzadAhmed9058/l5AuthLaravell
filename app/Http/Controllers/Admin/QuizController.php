<?php

namespace App\Http\Controllers\Admin;

use App\Admin\AnswerModel;
use App\Admin\Category;
use App\Admin\OptionModel;
use App\Admin\QuizModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manager()
    {
        $quizes = QuizModel::orderBy('id', 'desc')->paginate(5);
        return view('admin.Quiz.quiz')->with(compact('quizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = Category::all();
        return view('admin.Quiz.create_quiz')->with(compact('cats'));
    }

    public function getSubCategories($id)
    {
        $subcats = Category::find($id)->subCategories;
        $template = '';
        foreach ($subcats as $subcat) {
            $template .= '<option value="' . $subcat->id . '">' . $subcat->title . '</option>';
        }
        return response()->json(['subcats' => $template]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        $this->validate($request, [

            'sub_category_id' => 'required|not_in:default',
            'type' => 'required',
            'question' => 'required',
            'points' => 'required',
            'option.*' => 'required|distinct',
        ], [
            'option.*.required' => 'please enter option value',
            'option.*.distinct' => 'option value should not match with other options',
        ]);
        if ($request->type == 1 && isset($request->ans)) {
            if (count($request->ans) > 1 || count($request->ans) < 1) {
                Session::flash('message', 'please select one option because selected type is Radio');
                return redirect()->back();
            }
        }
        if ($request->type == 1 && !(isset($request->ans))) {
            Session::flash('message', 'please select one option because selected type is Radio');
            return redirect()->back();
        }
        if ($request->type == 2 && isset($request->ans)) {
            if (count($request->ans) == 1 || count($request->ans) < 1) {
                Session::flash('message', 'please select multiple options because selected type is CheckBox');
                return redirect()->back();
            }
        }
        if ($request->type == 2 && !(isset($request->ans))) {
            Session::flash('message', 'please select multiple options because selected type is CheckBox');
            return redirect()->back();
        }

        $quiz = new QuizModel($request->all());
        $quiz->save();

        for ($i = 0; $i < 4; $i++) {
            $option = new OptionModel;
            $option->quiz_model_id = $quiz->id;
            $option->option_desc = $request->option[$i];
            $option->save();
        }
//
        if ($request->type == 1) {
            for ($i = 0; $i < 4; $i++) {
                if (isset($request->ans[$i])) {
                    $answer = new AnswerModel;
                    $answer->quiz_model_id = $quiz->id;
                    $answer->cBox_index = $request->cbox[$i];
                    $answer->answer_desc = $request->ans[$i];
                    $answer->save();
                    break;
                }
            }
        } else {
            for ($i = 0; $i < 4; $i++) {
                if (isset($request->ans[$i])) {
                    $answer = new AnswerModel;
                    $answer->quiz_model_id = $quiz->id;
                    $answer->answer_desc = $request->ans[$i];
                    $answer->cBox_index = $request->cbox[$i];
                    $answer->save();
                } else {
                    $answer = new AnswerModel;
                    $answer->quiz_model_id = $quiz->id;
                    $answer->cBox_index = 'empty';
                    $answer->answer_desc = 'empty';
                    $answer->save();
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = QuizModel::find($id);
        $quizSubCategory = QuizModel::find($id)->subCategory;
        $quizCategory = $quizSubCategory->category;
        $quizOptions = QuizModel::find($id)->optionModels;
        $quizAnswers = QuizModel::find($id)->answerModels;
        $cats = Category::all();
        if (count($quizAnswers) > 1) {
            return view('admin.Quiz.edit_quiz',
                compact('quizSubCategory', 'quizCategory', 'cats', 'quiz', 'quizOptions', 'quizAnswers')
            );
        }
        $singleOption = $quizAnswers[0];
        return view('admin.Quiz.edit_quiz',
            compact('quizSubCategory', 'quizCategory', 'cats', 'quiz', 'quizOptions', 'singleOption')
        );
//        dd($quizAnswers);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'sub_category_id' => 'required|not_in:default',
            'type' => 'required',
            'question' => 'required',
            'points' => 'required',
            'option.*' => 'required|distinct',
        ], [
            'option.*.required' => 'please enter option value',
            'option.*.distinct' => 'option value should not match with other options',
        ]);

        if ($request->type == 1 && isset($request->ans)) {
            if (count($request->ans) > 1 || count($request->ans) < 1) {
                Session::flash('message', 'please select one option because selected type is Radio');
                return redirect()->back();
            }
        }
        if ($request->type == 1 && !(isset($request->ans))) {
            Session::flash('message', 'please select one option because selected type is Radio');
            return redirect()->back();
        }
        if ($request->type == 2 && isset($request->ans)) {
            if (count($request->ans) == 1 || count($request->ans) < 1) {
                Session::flash('message', 'please select multiple options because selected type is CheckBox');
                return redirect()->back();
            }
        }
        if ($request->type == 2 && !(isset($request->ans))) {
            Session::flash('message', 'please select multiple options because selected type is CheckBox');
            return redirect()->back();
        }


        $quiz = QuizModel::find($id);
        $quiz->fill($request->all());
        $quiz->save();

        $options = $quiz->optionModels;
        for ($i = 0; $i < 4; $i++) {
            $option = OptionModel::find($options[$i]->id);
            $option->quiz_model_id = $quiz->id;
            $option->option_desc = $request->option[$i];
            $option->save();
        }
//
        $answers = $quiz->answerModels;
//        dd($answers);
        if ($request->type == 1) {
            if (count($answers) > 1) {
                for ($i = 0; $i < 4; $i++) {
                    $delAnswer = AnswerModel::find($answers[$i]->id);
                    $delAnswer->delete();
                }
                for ($i = 0; $i < 4; $i++) {
                    if (isset($request->ans[$i])) {
                        $answer = new AnswerModel;
                        $answer->quiz_model_id = $quiz->id;
                        $answer->cBox_index = $request->cbox[$i];
                        $answer->answer_desc = $request->ans[$i];
                        $answer->save();
                        break;
                    }
                }
            } else {

                for ($i = 0; $i < 4; $i++) {
                    if (isset($request->ans[$i])) {
                        $answer = AnswerModel::find($answers[0]->id);
                        $answer->quiz_model_id = $quiz->id;
                        $answer->cBox_index = $request->cbox[$i];
                        $answer->answer_desc = $request->ans[$i];
                        $answer->save();
                        break;
                    }
                }
            }
        } else {
            if (count($answers) == 1) {
                $delAnswer = AnswerModel::find($answers[0]->id);
                $delAnswer->delete();
                for ($i = 0; $i < 4; $i++) {
                    if (isset($request->ans[$i])) {
                        $answer = new AnswerModel;
                        $answer->quiz_model_id = $quiz->id;
                        $answer->answer_desc = $request->ans[$i];
                        $answer->cBox_index = $request->cbox[$i];
                        $answer->save();
                    } else {
                        $answer = new AnswerModel;
                        $answer->quiz_model_id = $quiz->id;
                        $answer->cBox_index = 'empty';
                        $answer->answer_desc = 'empty';
                        $answer->save();
                    }
                }
            } else {
                for ($i = 0; $i < 4; $i++) {
                    if (isset($request->ans[$i])) {
                        $answer = AnswerModel::find($answers[$i]->id);
                        $answer->quiz_model_id = $quiz->id;
                        $answer->answer_desc = $request->ans[$i];
                        $answer->cBox_index = $request->cbox[$i];
                        $answer->save();
                    } else {
                        $answer = AnswerModel::find($answers[$i]->id);
                        $answer->quiz_model_id = $quiz->id;
                        $answer->cBox_index = 'empty';
                        $answer->answer_desc = 'empty';
                        $answer->save();
                    }
                }
            }
        }
        return redirect()->route('quiz.manager');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $quiz = QuizModel::findOrFail($id);
        $quiz->delete();
        return redirect()->back();
    }
}
