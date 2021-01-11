<?php

namespace App\Http\Controllers;

use App\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $majors = Major::latest()->paginate(10);

        return view('major.index', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'major' => 'required|min:5',
        ]);

        $major = Major::updateOrCreate(['id' => $request->id], [
            'title' => $request->title,
            'major' => $request->major
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Major created successfully',
            'data' => $major
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $major = Major::findOrFail($id);

        return response()->json($major);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $major->delete();

        return response()->json(['success'=>'Major deleted successfully']);
    }

    public function getMajor()
    {
        return view('case.index');
    }
}
