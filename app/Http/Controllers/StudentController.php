<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Exam;
use App\ExamCategory;
use App\ExamQuestion;
use App\ExamChoices;
use App\Section;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('student');
    }
    public function index()
    {
        $user = Student::where('user_id', Auth::id())->first();
        $section = Section::get();
        if (!$user) {
            return view('student.dashboard', compact('user', 'section'));
        } else {
            // return $user->section_id;
            $exam = Exam::where('section_id', $user->section_id)->get();
            return view('student.dashboard1',compact('user','exam'));
             //$category = ExamCategory::where('exam_id', $exam->id)->get();
            /*foreach ($category as $key => $value) {
                $answer = Answer::join('users','users.id','answers.user_id')->join('exam_categories','exam_categories.id','answers.categ_id')->where(['answers.user_id'=>Auth::id(),'answers.categ_id'=>$value->id])->first();
            
                $complete[] = array(
                    'id' => $value->id,
                    'completed' => $answer
                );
            }                           
            //return $data;
            return view('student.dashboard', compact('user', 'category','complete')); */
        }
    }
    public function examView($id){
        $user = Student::where('user_id', Auth::id())->first();
        $section = Section::get();
        $category = ExamCategory::where('exam_id', $id)->get();
        foreach ($category as $key => $value) {
            $answer = Answer::join('users','users.id','answers.user_id')->join('exam_categories','exam_categories.id','answers.categ_id')->where(['answers.user_id'=>Auth::id(),'answers.categ_id'=>$value->id])->first();
        
            $complete[] = array(
                'id' => $value->id,
                'completed' => $answer
            );
        }                           
        //return $data;
        return view('student.dashboard', compact('user', 'category','complete'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function viewExam()
    {
        return view('student.questionerLayout');
    }
    public function viewActivities()
    {
        //return view('student.dashboard');
        return view('student.activities');
    }
    public function viewResult()
    {
        $user_id = Auth::id();
        // Get the Student info
        $student = Student::join('sections','sections.id','students.section_id')->where('user_id',$user_id)->first();
        // Get the Text Exam
        $exam = Exam::where('section_id',$student->section_id)->first();
        // Get All categories of exams
        $category = ExamCategory::where('exam_id',$exam->id)->get();
        foreach ($category as $key => $value) {
            //$question = ExamQuestion::where()->get();
            $answers = Answer::where(['categ_id'=>$value->id, 'user_id'=>$user_id])->get();
            $total = 0;
            if($value->categ_name == ucwords('identification')){
                foreach($answers as $answer ){
                    $choice = ExamChoices::where(['question_id'=>$answer->question_id,'exam_answer'=>1])->first();
                    if($answer->answer == $choice->exam_choice){
                        $total+=1;
                    }
                    $questions[] = array(
                        'score' => $total
                    );
                }
            }else{
                foreach($answers as $answer ){
                    $choice = ExamChoices::where(['question_id'=>$answer->question_id,'exam_answer'=>1])->first();
                    if($answer->answer == $choice->exam_answer){
                        $total+=1;
                    }
                    $questions[] = array(
                        'score' => $total
                    );
                }
            }
            $results[] = array(
                'category' => $value->categ_name,
                'score' => $questions
            );
        }
        return $results;
        //return view('student.activities');
    }
    public function question(){
        
    }
    public function viewQuestionner($id)
    {
        $category = ExamCategory::where('id', $id)->get();
        $question = ExamQuestion::select('id', 'exam_question As Name')->where('categ_id', $id)->get();
        foreach ($question as $key => $value) {
            $check = ExamChoices::select('id As cId', 'exam_choice As choice')->where('question_id', $value->id)->get();
            if ($check) {
                $dataQuestion[] = array(
                    'question_id' => $value->id,
                    'question' => $value->Name,
                    'choices' => $check
                );
            }
        }
        $questions = $dataQuestion;
        return view('student.questionerLayout', compact('category', 'questions'));
    }

    public function storeStudent($account, $section)
    {
        $student = Student::create([
            'user_id' => $account,
            'section_id' => $section
        ]);
        return redirect()->back();
    }
    public function storeAnswer(Request $request)
    {
        $category = $request->input('type');
        if ($category == ucwords('multiple choice')) {
            //$data = 
            foreach ($request->input('answer') as $key => $value) {
                Answer::create([
                    'user_id' => (int) Auth::id(),
                    'question_id' => (int) $key,
                    'answer' => $value,
                    'categ_id'=> $request->input('id')
                ]);
            }
        } else if ($category == ucwords('identification')) {
            foreach ($request->input('name') as $key => $value) {
                Answer::create([
                    'user_id' => Auth::id(),
                    'question_id' => $key,
                    'answer' => $value,
                    'categ_id'=> $request->input('id')
                ]);
            }
            foreach ($request->input('operator') as $key => $value) {
                Answer::create([
                    'user_id' => Auth::id(),
                    'question_id' => $key,
                    'answer' => $value,
                    'categ_id'=> $request->input('id')
                ]);
            }
        } else if ($category == ucwords('problem solving') || $category == ucwords('forICT') ) {
            foreach ($request->input('answer') as $key => $value) {
                Answer::create([
                    'user_id' => (int) Auth::id(),
                    'question_id' => (int) $key,
                    'answer' => $value,
                    'categ_id'=> $request->input('id')
                ]);
            }
            
        }else{
            foreach ($request->input('answer') as $key => $value) {
                Answer::create([
                    'user_id' => (int) Auth::id(),
                    'question_id' => (int) $key,
                    'answer' => $value,
                    'categ_id'=> $request->input('id')
                ]);
            }
        }
        return redirect('/student');
    }
}
