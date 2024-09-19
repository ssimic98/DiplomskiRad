<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\AdoptionAnswer;
use App\Models\AdoptionQuestion;
use App\Notifications\AdoptionRequestNotification;
use App\Notifications\UserAdoptionStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Notification;
class AdoptionAnswersController extends Controller
{
    //Shelter pregledava sve zahjeve koje ima za pojedine pse
    public function showAllAdoptionRequests()
    {
        $answers = AdoptionAnswer::with('adoption', 'adoption.questions')->get()->map(function ($answer) {
            $answer->answers = json_decode($answer->answers, true);
            return $answer;
        });

        return view('shelter.dogs.showAdoptionRequests', compact('answers'));
    }

    //Shelter - azil pregledava odgovore pojeding korisnika 
    public function showAdoptionDetails($answerID)
    {
        $answer = AdoptionAnswer::with('adoption', 'adoption.questions', 'dog', 'user')->findOrFail($answerID);
        $answer->answers = json_decode($answer->answers, true);

        return view('shelter.dogs.adoptionAnswersDetail', compact('answer'));
    }
    public function acceptAnswer($answerID)
    {
        $answer = AdoptionAnswer::findOrFail($answerID);
        $answer->status = 'prihvaćen';
        $answer->save();
        $answer->user->notify(new UserAdoptionStatusNotification($answer,'prihvaćen'));
        return redirect()->route('shelter.dogs.showDogs')->with('message', 'Zahtjev prihvaćen');
    }
    public function rejectAnswer($answerID)
    {
        $answer = AdoptionAnswer::findOrFail($answerID);
        $answer->status = 'odbijen';
        $answer->save();
        $answer->user->notify(new UserAdoptionStatusNotification($answer,'odbijen'));
        return redirect()->route('shelter.dogs.showDogs')->with('message', 'Zahtjev odbijen');
    }
    //Odgovore sprema korisnik sa rolom user jer on odgovara na obrazac kojeg kreira azil(shelter)
    public function store(Request $request)
    {
        $questions = AdoptionQuestion::where('adoption_id', $request->adoption_id)->get();
        Log::info('Validirani podaci', $request->all());

        $validateData = [
            'adoption_id' => 'required|exists:adoptions,id',
            'dog_id' => 'required|exists:dogs,id',
        ];

        foreach ($questions as $question) {
            $key = 'answers.' . $question->id;

            if ($question->question_type == 'text') {
                $validateData[$key] = 'required|string';
            } elseif ($question->question_type == 'radio') {
                $validateData[$key] = 'required|string';
            } elseif ($question->question_type == 'checkbox') {
                $validateData[$key] = 'required|array|min:1';
            }
        }

        $customMessage = [
            'answers.*.required' => 'Ovo polje je obavezno.',
            'answers.*.array' => 'Polje mora biti u obliku niza.',
            'answers.*.min' => 'Morate označiti barem jedan izbor.',
        ];

        $request->validate($validateData, $customMessage);

        $adoptionAnswer = AdoptionAnswer::create([
            'adoption_id' => $request->adoption_id,
            'user_id' => auth()->id(),
            'dog_id' => $request->dog_id,
            'answers' => json_encode($request->answers),
            'status' => 'pending',
        ]);
        $this->sendAdoptionNotification($adoptionAnswer);

        return redirect()->route('user.showAllDogs')->with('message', 'Hvala što ste ispunili obrazac, odgovor će Vam doći uskoro!');
    }
    //Slanje notifkacije o zaprimljenoj notifikaciji korisniku shelter
    protected function sendAdoptionNotification(AdoptionAnswer $adoptionAnswer)
    {
        $adoption = $adoptionAnswer->adoption;
        $shelterUser = $adoption->shelter;
        Notification::send($shelterUser, new AdoptionRequestNotification($adoptionAnswer));
    }
    //Označavanje svih primljenih poruka pročitanim
    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}




