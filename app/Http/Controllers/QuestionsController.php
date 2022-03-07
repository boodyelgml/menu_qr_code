<?php
namespace App\Http\Controllers;
use App\questions;
use App\restaurant;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;
class QuestionsController extends Controller
{
    // ========== all questions ========//
    public function index()
    {
        $moderatorID = \Auth::user()->id;
        $userRole = \Auth::user()->role;

        $questions = questions::all();
        $restaurants = restaurant::all();

         // fix language
         foreach ($restaurants as $restaurant) {
            if ($restaurant->language == 2) {
                $restaurant->name = $restaurant->name_ar;
            }
        }
        // fix language
        foreach ($questions as $question) {
            foreach($question->restaurants as $restaurant){
                if ($restaurant->language == 2) {
                    $restaurant->name = $restaurant->name_ar;
                }
            }

        }

        // moderator
        if ($userRole == 2) {

            $allQuestions = array();
            foreach ($questions as $question) {
                foreach ($question->restaurants as $restaurant) {
                    if ($restaurant->user_id == $moderatorID) {
                        $allQuestions[] = $question;
                    }
                }
            }

            $allRestaurants = array();
            foreach ($restaurants as $restaurant) {
                if ($restaurant->language == 2) {
                    $restaurant->name = $restaurant->name_ar;
                }
                if ($restaurant->user_id == $moderatorID) {

                    $allRestaurants[] = $restaurant;
                }
            }
            return view('rating.questions.questions', ['questions' => $allQuestions,  'restaurants' => $allRestaurants]);
        }

        // super admin
        elseif ($userRole == 1) {
            return view('rating.questions.questions', ['questions' => $questions, 'restaurants' => $restaurants]);
        }

    }
    // ========== add question ========//
    public function create(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'question_ar' => 'required|string|min:4',
            'is_visible' => 'required|string|min:1',
            'restaurant_id' => 'required',
        ]);
        $newQuestion = new questions();
        $newQuestion->question = $request->question;
        $newQuestion->question_ar = $request->question_ar;
        $newQuestion->is_visible = $request->is_visible;
        $newQuestion->save();
        $newQuestion->restaurants()->syncWithoutDetaching($request->restaurant_id);
    }
    // ========== edit one question ========//
    public function edit($id)
    {
        $userRole = \Auth::user()->role;
        $userID = \Auth::user()->id;
        $questions = questions::where('id' , $id)->get();
        $restaurants = restaurant::all();

         // not found
         if (count($questions) == 0) {
            abort(404);
        }

        foreach($questions[0]->restaurants as $restaurant){
            if ($userID === $restaurant->user_id || $userRole === 1) {
                return view('rating.questions.Editquestions', ['questions' => $questions, 'restaurants' => $restaurants]);
            } else { // unauthorized
                return view("unAuthorized.unAuthorized");
            }
        }


    }
    // ========== update one question ========//
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'question_ar' => 'required|string|min:4',
            'is_visible' => 'required|string|min:1',
        ]);
        $EditQuestion = questions::find($id);
        $EditQuestion->question = $request->question;
        $EditQuestion->question_ar = $request->question_ar;
        $EditQuestion->is_visible = $request->is_visible;
        $EditQuestion->save();
        if ($request->restaurant_id &&  count($request->restaurant_id) > 0) {
            $EditQuestion->restaurants()->syncWithoutDetaching($request->restaurant_id);
        }
    }
    // ========== delete question ========//
    public function destroy($id)
    {
        $Question = questions::find($id)->delete();
    }
}
