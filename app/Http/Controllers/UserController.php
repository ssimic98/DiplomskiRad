<?php

namespace App\Http\Controllers;

use App\Models\AdoptionAnswer;
use Illuminate\Http\Request;
use App\Models\Dog;
use App\Models\Adoption;
use App\Http\Controllers\AdoptionAnswersController;
use Illuminate\Support\Facades\Auth;

use App\Models\HealthStatus;
use App\Models\Breed;
use App\Models\Characteristic;
use App\Models\Gender;
class UserController extends Controller
{

    public function showDog(Dog $dog)
    {
        $user=auth()->user();
        return view('user.showDog',compact('dog','user'));
    }
    public function showFavoriteDogs(Dog $dogs)
    {
        $user=auth()->user();
        $favoritedogs=$user->favoriteDogs()->get();
        return view('user.showfavoriteDogs',compact('user','favoritedogs'));
    }


    public function showAdoptionForm(Dog $dog)
    {
        $user=auth()->user();
        $adoption = Adoption::where('shelter_id', $dog->user_id)->first();
        if (!$adoption) {
            return redirect()->back()->with('error', 'Nema dostupne ankete za ovog psa.');
        }

        $existingAnswer=AdoptionAnswer::where('adoption_id',$adoption->id)
                                        ->where('dog_id',$dog->id)
                                        ->where('user_id',$user->id)
                                        ->where('status','pending')
                                        ->first();

        if($existingAnswer)
        {
            return redirect()->back()->with('message', 'Već ste poslali obrazac za ovog psa! Pričekajte odgovor prije ponovnog slanja.');
        }

        $questions = $adoption->questions->map(function ($question) {
            $question->options = json_decode($question->options, true);
            return $question;
        });

        return view('user.adoptionForm', compact('dog', 'adoption', 'questions'));
    }

    public function showAdoptionStatus($answerID)
    {
        
        $adoptionAnswer=AdoptionAnswer::with('dog','user')->findOrFail($answerID);
        return view('user.adoptionStatus',compact('adoptionAnswer'));
    }

    public function showAnsweredRequests()
    {
        $answers = AdoptionAnswer::with('adoption', 'adoption.questions')->get()->map(function ($answer) {
            $answer->answers = json_decode($answer->answers, true);
            return $answer;
        });

        return view('user.showAnsweredAdoptionRequests', compact('answers'));
    }



}
