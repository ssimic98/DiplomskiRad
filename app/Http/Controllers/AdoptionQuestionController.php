<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\AdoptionQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class AdoptionQuestionController extends Controller
{
    public function showAdoption()
    {
        $adoptions = Adoption::where('shelter_id', Auth::id())->get();
        return view('shelter.dogs.adoption', compact('adoptions'));
    }
    public function showAdoptionQuestionsDetails($adoptionID)
    {
        $adoption = Adoption::with('questions')->where('shelter_id', Auth::id())->findOrFail($adoptionID);
        return view('shelter.dogs.adoptionDetail', compact('adoption'));
    }
    // Metoda za prikaz forme za kreiranje obrasca
    public function createQuestions()
    {
        $existingAdoption=Adoption::where('shelter_id',Auth::id())->first();
        if($existingAdoption)
        {
            return redirect()->route('shelter.dogs.showDogs')->with('error','Već imate jedan obrazac. Ako želite novi morate obrisat postojeći!');
        }
        return view('shelter.dogs.adoptionsQuestionCreate');
    }

    //Metoda za spremanje obrasca
    public function storeQuestions(Request $request)
    {
        $existingAdoption=Adoption::where('shelter_id',Auth::id())->first();
        if($existingAdoption)
        {
            return redirect()->route('shelter.dogs.showDogs')->with('error','Već imate jedan obrazac. Ako želite novi morate obrisat postojeći!');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.question_type' => 'required|in:text,radio,checkbox',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'nullable|string|max:255',
        ]);


        $adoption = Adoption::create([
            'shelter_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        foreach ($request->input('questions', []) as $question) {
            $questionType = $question['question_type'];
            $options = $questionType === 'text' ? [] : ($question['options'] ?? []);

            AdoptionQuestion::create([
                'adoption_id' => $adoption->id,
                'question_text' => $question['question_text'],
                'question_type' => $questionType,
                'options' => json_encode($options) // Pretvorba u JSON format
            ]);
        }

        return redirect()->route('shelter.dogs.showDogs')->with('message', 'Obrazac uspješno kreiran!');
    }

    public function deleteAdoptionQuestions($adoptionID)
    {
        $adoption=Adoption::where('id',$adoptionID)->where('shelter_id',Auth::id())->firstOrFail();

        if($adoption->shelter_id != Auth::id())
        {
            return redirect()->route('shelter.dogs.showDogs')->with('error','Već imate jedan obrazac. Ako želite novi morate obrisat postojeći!');
        }
        $adoption->delete();
        return redirect()->route('shelter.dogs.showDogs')->with('message', 'Obrazac uspješno obrisan!');
    }
}
