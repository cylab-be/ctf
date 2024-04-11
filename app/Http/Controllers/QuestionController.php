<?php
namespace App\Http\Controllers;

use App\Question;
use App\Set;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Set $set)
    {
        return view("question.index", ["questions" => $set->questions]);
    }

    /**
     * Show the form for creating a new resource.
     * We use the same view for create and update => provide an empty Question.
     *
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
     */
    public function store(Set $set, Request $request)
    {
        $question = new Question();
        $question->set()->associate($set);
        
        return $this->saveAndRedirect($request, $question);
    }
    
    public function saveAndRedirect(Request $request, Question $question)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'statement' => 'required|string',
            'flag' => 'required|string',
            'max_submissions' => 'required|integer|min:1',
            'points' => 'required|integer|min:1'
        ]);
        
        $question->name = $request->name;
        $question->statement = $request->statement;
        $question->flag = $request->flag;
        $question->max_submissions = $request->max_submissions;
        $question->points = $request->points;
        $question->save();

        toastr()->info("Question saved");

        if (! is_null($request->input('save-add'))) {
            return redirect(action('QuestionController@create', ['set' => $question->set]));
        }

        return redirect(action('QuestionController@edit', [
            'question' => $question,
            'set' => $question->set]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Question $question
     */
    public function show(Set $set, Question $question)
    {
        return view("question.show", ["question" => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Question $question
     */
    public function edit(Set $set, Question $question)
    {
        return view("question.edit", ["question" => $question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Question $question
     */
    public function update(Set $set, Request $request, Question $question)
    {
        return $this->saveAndRedirect($request, $question);
    }

    /**
     * Move a question to another question set.
     *
     * @param Set $set
     * @param Question $question
     */
    public function move(Set $set, Question $question, Request $request)
    {
        $new_set_id = $request->input("new_set_id");
        $question->set_id = $new_set_id;
        $question->save();

        toastr()->info("Question was moved");
        return redirect(action("SetController@show", ['set' => $set]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Set $set, $id)
    {
        Question::find($id)->delete();
        toastr()->info("Question was deleted!");
        return redirect(action("SetController@show", ['set' => $set]));
    }
}
