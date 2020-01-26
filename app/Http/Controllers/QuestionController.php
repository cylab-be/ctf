<?php
namespace App\Http\Controllers;

use App\Question;
use App\Set;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function __construct()
    {
        // Uncomment to require authentication
        // $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|regex:/^[a-zA-Z0-9\s-\.]+$/|max:255',
            'statement' => 'required|string',
            'flag' => 'required|string',
            'max_submissions' => 'required|integer'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Set $set)
    {
        return view("question.index", array("questions" => $set->questions));
    }

    /**
     * Show the form for creating a new resource.
     * We use the same view for create and update => provide an empty Question.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Set $set)
    {
        $q = new Question();
        $q->set = $set;
        return view("question.edit", ["question" => $q]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Set $set, Request $request)
    {
        $this->validator($request->all())->validate();

        $question = new Question();
        $question->set()->associate($set);
        $question->name = $request->name;
        $question->statement = $request->statement;
        $question->flag = $request->flag;
        $question->max_submissions = $request->max_submissions;
        $question->save();
        return redirect(action('SetController@show', ['set' => $set]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Question $question     * @return \Illuminate\Http\Response
     */
    public function show(Set $set, Question $question)
    {
        return view("question.show", array("question" => $question));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Question $question     * @return \Illuminate\Http\Response
     */
    public function edit(Set $set, Question $question)
    {
        return view("question.edit", array("question" => $question));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Question $question     * @return \Illuminate\Http\Response
     */
    public function update(Set $set, Request $request, Question $question)
    {
        $this->validator($request->all())->validate();

        $question->name = $request->name;
        $question->statement = $request->statement;
        $question->flag = $request->flag;
        $question->max_submissions = $request->max_submissions;
        $question->save();
        return redirect(action("SetController@show", ['set' => $set]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Set $set, $id)
    {
        Question::find($id)->delete();
        return redirect(action("SetController@show", ['set' => $set]));
    }
}
