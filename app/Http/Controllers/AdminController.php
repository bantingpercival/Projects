<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Exam;
use App\ExamCategory;
use App\ExamChoices;
use App\ExamQuestion;
use App\Section;
use App\Student;
use Illuminate\Http\Request;
use App\Subject;
use App\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function index()
    {
        return view('admin.dashboard');
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
        return view('student.examQuestioner');
    }
    public function viewActivities()
    {
        return view('student.activities');
    }
    public function viewSubject()
    {
        $subject = Subject::get();
        return view('admin.subject', compact('subject'));
    }
    public function viewSection()
    {
        $subject = Subject::get();
        $sections = Section::join('subjects', 'subjects.id', 'sections.subject_id')->get();
        return view('admin.section', compact('subject', 'sections'));
    }
    public function viewSections()
    {
        $sections = Section::select('sections.id', 'sections.section_name', 'sections.section_grade')->join('subjects', 'subjects.id', 'sections.subject_id')->get();
        return view('admin.sections', compact('sections'));
    }
    public function viewStudent($id)
    {
        $students = Student::select('users.name', 'users.id')->join('users', 'users.id', 'students.user_id')->where('students.section_id', $id)->get();
        foreach ($students as $key => $student) { 
            $score[] = array(
                'id' => $student->id,
                'name' => $student->name,
                'score' => $this->score($student->id,$id)
            ); 
        }
        $students = $score;
        //return $score;
        return view('admin.students', compact('students'));
    }
    public function score($id, $section)
    {
        $sections = Exam::select('exam_categories.id', 'categ_name', 'item_points', 'categ_instruction')->join('exam_categories', 'exam_categories.exam_id', 'exams.id')->where('exams.section_id', $section)->get();
        $result = 0;
        foreach ($sections as $key => $section) {
            if ($section->categ_name == ucwords('multiple choice')) {
                $questions = DB::select('SELECT EQ.EXAM_QUESTION, EC.ID AS CHOICE_ID, EC.EXAM_CHOICE AS CORRECT_ANSWER, ANSWERS.ANSWER, (SELECT EXAM_CHOICE FROM exam_choices WHERE exam_choices.id = answers.answer) AS CHOICE_ANSWER,IF(EC.ID=ANSWERS.ANSWER,exam_categories.item_points,0) AS SCORE FROM EXAM_QUESTIONS AS EQ INNER JOIN EXAM_CHOICES AS EC ON EQ.ID = EC.QUESTION_ID INNER JOIN ANSWERS ON ANSWERS.QUESTION_ID = EQ.ID INNER JOIN exam_categories ON exam_categories.id = EQ.categ_id WHERE ANSWERS.USER_ID = ? AND EC.EXAM_ANSWER = 1 AND EQ.CATEG_ID = ?', [$id, $section->id]);
            } else {
                $questions = DB::select('SELECT EQ.EXAM_QUESTION, EC.ID AS CHOICE_ID, EC.EXAM_CHOICE AS CORRECT_ANSWER, ANSWERS.ANSWER AS CHOICE_ANSWER,IF(EC.EXAM_CHOICE=ANSWERS.ANSWER,exam_categories.item_points,0) AS SCORE FROM EXAM_QUESTIONS AS EQ INNER JOIN EXAM_CHOICES AS EC ON EQ.ID = EC.QUESTION_ID INNER JOIN ANSWERS ON ANSWERS.QUESTION_ID = EQ.ID INNER JOIN exam_categories ON exam_categories.id = EQ.categ_id WHERE ANSWERS.USER_ID = ? AND EC.EXAM_ANSWER = 1 AND EQ.CATEG_ID = ?', [$id, $section->id]);
            }
            $total = 0;
            foreach ($questions as $score) {
                $total += $score->SCORE;
            }
            $result += $total;
        }
        return $result;
    }
    public function answerCheck($section_id, $student_id)
    {
        $user = User::where('id', $student_id)->first();
        $sections = Exam::select('exam_categories.id', 'categ_name', 'item_points', 'categ_instruction')->join('exam_categories', 'exam_categories.exam_id', 'exams.id')->where('exams.section_id', $section_id)->get();
        $result = 0;
        foreach ($sections as $key => $section) {
            if ($section->categ_name == ucwords('multiple choice')) {
                $questions = DB::select('SELECT EQ.EXAM_QUESTION, EC.ID AS CHOICE_ID, EC.EXAM_CHOICE AS CORRECT_ANSWER, ANSWERS.ANSWER, (SELECT EXAM_CHOICE FROM exam_choices WHERE exam_choices.id = answers.answer) AS CHOICE_ANSWER,IF(EC.ID=ANSWERS.ANSWER,exam_categories.item_points,0) AS SCORE FROM EXAM_QUESTIONS AS EQ INNER JOIN EXAM_CHOICES AS EC ON EQ.ID = EC.QUESTION_ID INNER JOIN ANSWERS ON ANSWERS.QUESTION_ID = EQ.ID INNER JOIN exam_categories ON exam_categories.id = EQ.categ_id WHERE ANSWERS.USER_ID = ? AND EC.EXAM_ANSWER = 1 AND EQ.CATEG_ID = ?', [$student_id, $section->id]);
            } else {
                $questions = DB::select('SELECT EQ.EXAM_QUESTION, EC.ID AS CHOICE_ID, EC.EXAM_CHOICE AS CORRECT_ANSWER, ANSWERS.ANSWER AS CHOICE_ANSWER,IF(EC.EXAM_CHOICE=ANSWERS.ANSWER,exam_categories.item_points,0) AS SCORE FROM EXAM_QUESTIONS AS EQ INNER JOIN EXAM_CHOICES AS EC ON EQ.ID = EC.QUESTION_ID INNER JOIN ANSWERS ON ANSWERS.QUESTION_ID = EQ.ID INNER JOIN exam_categories ON exam_categories.id = EQ.categ_id WHERE ANSWERS.USER_ID = ? AND EC.EXAM_ANSWER = 1 AND EQ.CATEG_ID = ?', [$student_id, $section->id]);
            }
            $answer_check[] = array(
                'categ_name' => $section->categ_name,
                'instruction' => $section->categ_instruction,
                'questions' => $questions
            );
            $total = 0;
            foreach ($questions as $score) {
                $total += $score->SCORE;
            }
            $result += $total;
        }
        $student_result = array(
            'name' => $user->name,
            'exam_score' => $result,
            'result_exam' => $answer_check
        );
        //return $result;
        //return $student_result;
        return view('admin.viewResult', compact('student_result'));
    }
    public function viewMakeExam()
    {
        $exams = Exam::select('exams.id', 'exams.item_number', 'exams.exam_name', 'sections.section_name')->join('sections', 'sections.id', 'exams.section_id')->get();
        $sections = Section::get();
        return view('admin.makeExam', compact('sections', 'exams'));
    }
    public function createExam($id)
    {
        $exams = Exam::select('exams.id', 'exams.item_number', 'exams.exam_name', 'sections.section_name')->join('sections', 'sections.id', 'exams.section_id')->where('exams.id', $id)->get();
        $category = ExamCategory::where('exam_id', $id)->get();
        return view('admin.examLayout', compact('category', 'exams'));
    }
    public function createQuestion($id, $dataId)
    {
        $category = ExamCategory::where('id', $dataId)->get();
        return view('admin.questionLayout', compact('category'));
    }
    public function viewQuestionner($id)
    {
        $category = ExamCategory::where('id', $id)->get();
        $question = ExamQuestion::select('id', 'exam_question As Name')->where('categ_id', $id)->get();
        foreach ($question as $key => $value) {
            $check = ExamChoices::select('id As cId', 'exam_choice As choice', 'exam_answer As answer')->where('question_id', $value->id)->get();
            if ($check) {
                $dataQuestion[] = array(
                    'question_id' => $value->id,
                    'question' => $value->Name,
                    'choices' => $check
                );
            }
        }
        $questions = $dataQuestion;
        return view('admin.viewQuestionner', compact('category', 'questions'));
    }

    public function viewChoice($id)
    {
        $answer =  ExamQuestion::select('exam_choices.exam_choice')->join('exam_choices', 'exam_choices.question_id', 'exam_questions.id')->where('exam_questions.categ_id', $id)->inRandomOrder()->get();
        return view('admin.questionChoice', compact('answer'));
        //return view();
    }

    public function storeSubject(Request $request)
    {
        Subject::create([
            'subject_name' => ucwords($request->input('name')),
        ]);
        return redirect()->route('subject')->withStatus(__('Subject successfully created.'));
    }
    public function storeSection(Request $request)
    {
        Section::create([
            'section_name' => ucwords($request->input('section_name')),
            'section_grade' => ucwords($request->input('section_grade')),
            'subject_id' => $request->input('subject_id'),
            'active' => 1
        ]);
        return redirect()->route('section')->withStatus(__('Section successfully created.'));
    }
    public function storeExam(Request $request)
    {
        Exam::create([
            'exam_name' => ucwords($request->input('exam_name')),
            'section_id' => $request->input('section_id'),
            'item_number' => $request->input('item')
        ]);
        return redirect()->route('makeExam')->withStatus('Successfully Created Exammination');
    }
    public function storeExamCategory(Request $request)
    {
        ExamCategory::create([
            'exam_id' => $request->input('id'),
            'categ_name' => ucwords($request->input('categ_name')),
            'categ_instruction' => ucwords($request->input('instruction')),
            'item_number' => $request->input('item'),
            'item_points' => $request->input('score')
        ]);
        return redirect()->back()->withStatus('Successfully');
    }
    public function storeExamQuestion(Request $request)
    {
        $data = ExamQuestion::create([
            'categ_id' => $request->input('id'),
            'exam_question' => $request->input('question')
        ]);
        $id = $data->id;
        foreach ($request->input('choices') as $key => $value) {

            if ($value) {
                $data = array(
                    'exam_choice' => ucwords($value),
                    'exam_answer' => $request->input('answer')[$key],
                    'question_id' => $id
                );
                ExamChoices::create($data);
                //return $data;
            }
        }
        return redirect()->back()->withStatus('Successfully');
    }
    public function activeAnswer($id)
    {
        ExamChoices::where('id', $id)->update(['exam_answer' => 1]);
        return redirect()->back();
    }
    public function changeChoice(Request $request)
    {
        ExamChoices::where('id', $request->input('id'))->update(['exam_choice' => ucwords($request->input('input'))]);
        return redirect()->back();
    }
}
