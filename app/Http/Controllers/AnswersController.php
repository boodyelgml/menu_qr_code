<?php

namespace App\Http\Controllers;

use App\answers;
use App\branch;
use App\feedback_text;
use App\questions;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    // ========== get all answers ==========//
    public function index()
    {
        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;

        $answers = answers::all();
        $branches = branch::all();
        $feedbacks = feedback_text::all();


        foreach ($answers as $answer) {
            if ($answer->restaurant->language == 2) {
                $answer->restaurant->name = $answer->restaurant->name_ar;
            }
        }
        foreach ($feedbacks as $feedback) {
            if ($feedback->restaurant->language == 2) {
                $feedback->restaurant->name = $feedback->restaurant->name_ar;
            }
        }

        // moderator
        if ($userRole == 2) {

            $allAnswers = array();
            foreach ($answers as $answer) {
                if ($answer->restaurant->user_id == $moderatorID) {
                    $allAnswers[] = $answer;
                }
            }

            $allFeedback = array();
            foreach ($feedbacks as $feedback) {
                if ($feedback->restaurant->language == 2) {
                    $feedback->restaurant->name = $feedback->restaurant->name_ar;
                }
                if ($feedback->restaurant->user_id == $moderatorID) {
                    $allFeedback[] = $feedback;
                }
            }

            return view('rating.answers.answers', ['answers' => $allAnswers, 'branches' => $branches, 'feedbacks' => $allFeedback]);
        }
        // super admin
        elseif ($userRole == 1) {
            return view('rating.answers.answers', ['answers' => $answers, 'branches' => $branches, 'feedbacks' => $feedbacks]);
        }
    }
    // ========== new answer ==========//
    public function create(Request $request)
    {
        $question_id = $request->question_id;
        $answer = $request->answer;
        for ($count = 0; $count < count($answer); $count++) {
            $data = array(
                'answer' => $answer[$count],
                'branch_id'  => $request->branch_id,
                'question_id' => $question_id[$count],
                'restaurant_id' => $request->restaurant_id,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $insert_data[] = $data;
        }
        $answers = new answers();
        $answers->insert($insert_data);
        if (strlen($request->feedback) > 1) {
            $feedback = new feedback_text();
            $feedback->branch_id = $request->branch_id;
            $feedback->feedback = $request->feedback;
            $feedback->restaurant_id = $request->restaurant_id;
            $feedback->save();
        }
    }
}
