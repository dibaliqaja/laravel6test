<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Major;
use App\Student;
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::latest()->paginate(10);

        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $majors = Major::all();

        return view('student.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $student = new Student();
        $student->create($request->validated());

        return redirect()->route('students.index')
            ->with('alert', 'Student added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $majors = Major::all();
        $student = Student::findOrFail($id);

        return view('student.edit', compact('majors', 'student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->validated());

        return redirect()->route('students.index')
            ->with('alert','Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')
            ->with('alert','Student deleted successfully.');
    }

    public function getDataAllStudent()
    {
        $students = Student::with('major:id,title,major')
            ->select('id', 'name', 'age', 'phone_number', 'email', 'major_id')
            ->latest()
            ->get();

        return $this->result($students, 'Get data all student.');
    }

    public function getDataAllStudentWithFilter($major_id)
    {
        $students = Student::with('major:id,title,major')
            ->where('major_id', $major_id)
            ->select('id', 'name', 'age', 'phone_number', 'email', 'major_id')
            ->latest()
            ->get();

        return $this->result($students, 'Get data all student with filter major_id.');
    }

    protected function responseData($message, $status, $data = null)
    {
        return response()->json([
            'message'   => $message,
            'status'    => $status,
            'data'      => $data
        ], $status);
    }

    protected function result($data, $message)
    {
        try {
            if (!$data->isEmpty()) {
                return $this->responseData($message, 200, $data);
            }

            return $this->responseData($message, 404, 'Not Found.');
        } catch (Exception $ex) {
            return $this->responseData($ex->getMessage(),500);
        }
    }
}
