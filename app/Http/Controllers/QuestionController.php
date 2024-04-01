<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Mail\QuestionMail;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Question::all();
        return response()->json(new QuestionCollection($data));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'notes' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => 0, 'type' => 'validation_filed', 'error' => $validator->messages()], 422);
        }
        $data = Question::create([
            'name' => $request->name,
            'email' => $request->email,
            'notes' => $request->notes ?? null
        ]);

        $content = [
            'subject' => 'есть вопрос',
            'body' => $data
        ];
        Mail::to('info@brend-instrument.ru')->send(new QuestionMail($content));
        return response()->json([
            "status" => 200,
        ]);
    }


    public function groupDelete(Request $request)
    {
        $questions = Question::whereIn('id', $request->ids)->get();
        foreach ($questions as $question) {
            $question->delete();
        }

        return response()->json([
            'status' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
