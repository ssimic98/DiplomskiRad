<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\HealthStatus;
use App\Models\Breed;
use App\Models\Characteristic;
use App\Models\Gender;
class DogController extends Controller
{
    //prikaza pasa azil
    public function shelterShowDogs()
    {
        $user = auth()->user();
        $dogs = Dog::with(['breed', 'gender', 'healthstatuses', 'characteristics'])->where('user_id', Auth::id())->get();
        return view('shelter.dogs.showDogs', compact('dogs', 'user'));
    }
    //prikaz pasa korisniku
    public function showDogs(Request $request)
    {
        $breeds = Breed::all();
        $characteristics = Characteristic::all();
        $healthstatus = HealthStatus::all();
        $user = auth()->user();

        // Postavljanje upita
        $query = Dog::query();

        // Filtriranje po karakteristikama
        if ($request->has('characteristics') && $request->characteristics !== null) {
            $query->whereHas('characteristics', function ($q) use ($request) {
                $q->whereIn('characteristics.id', $request->characteristics);
            });
        }

        // Filtriranje po statusu
        if ($request->has('status') && $request->status !== null) {
            $query->whereHas('healthstatuses', function ($q) use ($request) {
                $q->whereIn('health_statuses.id', $request->status);
            });
        }

        // Filtriranje po pasmini
        if ($request->has('breed_id') && $request->breed_id !== null) {
            $query->where('breed_id', $request->breed_id);
        }

        // Filtriranje po lokaciji
        if ($request->has('location') && $request->location !== null) {
            $query->where('location', $request->location);
        }

        // Filtriranje po statusu udomljavanja
        if ($request->has('is_adopted') && $request->is_adopted !== null) {
            $query->where('is_adopted', $request->is_adopted);
        }

        // Dohvati filtrirane pse
        $dogs = $query->get();

        return view('user.showAllDogs', compact('dogs', 'breeds', 'characteristics', 'healthstatus', 'user'));
    }
    public function showDog(Dog $dog)
    {
        $user = auth()->user();
        return view('user.showDog', compact('dog', 'user'));
    }
    public function createDog()
    {
        $healthStatuses = HealthStatus::all();
        $breeds = Breed::all();
        $characteristics = Characteristic::all();
        $genders = Gender::all();
        return view('shelter.dogs.createDog', compact('characteristics', 'breeds', 'genders', 'healthStatuses'));
    }
    public function storeDog(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u|string|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'poster' => 'required|mimes:jpeg,png,jpg',
            'location' => 'required|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u|string|max:255',
            'description' => 'required|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž,.\s-]+$/u|string|max:1000',
            'gender_id' => 'required|exists:genders,id',
            'characteristics' => 'required|array|min:1',
            'characteristics.*' => 'exists:characteristics,id',
            'health_statuses' => 'required|array|min:1',
            'health_statuses.*' => 'exists:health_statuses,id',
            'birth_date' => 'required|date',
        ], [
            'name.regex' => 'Ime može sadržavati samo slova',
            'location.regex' => ' Mjesto može sadržavati samo slova',
            'poster.mimes' => ' Slika može biti samo jpeg,png ili jpg format',
            'health_statuses.required' => 'Morate izabrat barem jedan od ponuđenih mogućnosti',
            'health_statuses.*.exists' => 'Izabrani zdravstveni status nije validan.',
            'characteristics.required' => 'Morate izabrat barem jedan od ponuđenih mogućnosti',
            'description.regex' => 'Opis može sadržavati samo slova',
        ]);


        if ($request->hasFile('poster')) {
            if ($request->file('poster')->isValid()) {
                $posterPath = $request->file('poster')->store('posters', 'public');
            } else {
                return back()->withErrors(['errors' => 'Učitana neispravna datoteka. Pokušajte ponovno']);
            }
        } else {
            return back()->withErrors(['error' => 'Datoteka nije učitana.']);
        }

        $dog = Dog::create([
            'name' => $request->name,
            'breed_id' => $request->breed_id,
            'poster' => $posterPath,
            'location' => $request->location,
            'health_status' => $request->health_status,
            'birth_date' => $request->birth_date,
            'description' => $request->description,
            'characteristics' => $request->characteristics,
            'gender_id' => $request->gender_id,
            'is_adopted' => false,
            'user_id' => Auth::id(),
        ]);
        $dog->characteristics()->attach($request->characteristics);
        $dog->healthstatuses()->attach($request->health_statuses);
        return redirect()->route('shelter.dogs.showDogs')->with('message', 'Pas uspješno dodan');
    }

    public function editDog($id)
    {
        $dog = Dog::with(['breed', 'healthstatuses', 'gender', 'characteristics'])->findOrFail($id);
        $healthStatuses = HealthStatus::all();
        $breeds = Breed::all();
        $characteristics = Characteristic::all();
        $genders = Gender::all();

        return view('shelter.dogs.editDog', compact('dog', 'healthStatuses', 'breeds', 'characteristics', 'genders'));
    }
    public function updateDog(Request $request, $id)
    {
        $dog = Dog::findOrFail($id);

        $request->validate([
            'name' => 'required|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u|string|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'poster' => 'required|mimes:jpeg,png,jpg',
            'location' => 'required|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u|string|max:255',
            'description' => 'required|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž,.\s-]+$/u|string|max:1000',
            'gender_id' => 'required|exists:genders,id',
            'characteristics' => 'required|array|min:1',
            'characteristics.*' => 'exists:characteristics,id',
            'health_statuses' => 'required|array|min:1',
            'health_statuses.*' => 'exists:health_statuses,id',
            'birth_date' => 'required|date',
        ], [
            'name.regex' => 'Ime može sadržavati samo slova',
            'location.regex' => ' Mjesto može sadržavati samo slova',
            'poster.mimes' => ' Slika može biti samo jpeg,png ili jpg format',
            'health_statuses.required' => 'Morate izabrat barem jedan od ponuđenih mogućnosti',
            'health_statuses.*.exists' => 'Izabrani zdravstveni status nije validan.',
            'characteristics.required' => 'Morate izabrat barem jedan od ponuđenih mogućnosti',
            'description.regex' => 'Opis može sadržavati samo slova',
        ]);

        if ($request->hasFile('poster')) {
            if ($request->file('poster')->isValid()) {
                $posterPath = $request->file('poster')->store('posters', 'public');
            } else {
                return back()->withErrors(['errors' => 'Učitana neispravna datoteka. Pokušajte ponovno']);
            }
        } else {
            return back()->withErrors(['error' => 'Datoteka nije učitana.']);
        }

        $dog->update([
            'name' => $request->name,
            'breed_id' => $request->breed_id,
            'poster' => $posterPath,
            'location' => $request->location,
            'health_status' => $request->health_status,
            'birth_date' => $request->birth_date,
            'description' => $request->description,
            'characteristics' => $request->characteristics,
            'gender_id' => $request->gender_id,
            'is_adopted' => $request->input('is_adopted', false),
            'user_id' => Auth::id(),
        ]);

        $dog->healthstatuses()->sync($request->health_statuses);
        $dog->characteristics()->sync($request->characteristics);
        return redirect()->route('shelter.dogs.showDogs')->with('message', 'Pas uspješno ažuriran.');
    }

    public function deleteDog($id)
    {
        $dog = Dog::findOrFail($id);

        $dog->characteristics()->detach();
        $dog->healthstatuses()->detach();

        $dog->delete();

        return redirect()->route('shelter.dogs.showDogs')->with('message', 'Pas uspješno obrisan');
    }

    public function filterAndSort(Request $request)
    {

        $breeds = Breed::all();
        $characteristics = Characteristic::all();
        $healthstatus = HealthStatus::all();
        $genders = Gender::all();
        $user = auth()->user();
        $query = Dog::query();
        // Filtriranje po karakteristikama tako da mora imati sve odabrane statuse koje korisnik postavi
        if ($request->has('characteristics') && $request->characteristics !== null) {
            //prolazi kroz svaku karakteristiku
            foreach ($request->characteristics as $characteristicsID)
                $query->whereHas('characteristics', function ($q) use ($characteristicsID) {
                    $q->where('characteristics.id', $characteristicsID);
                });
        }

        // Filtriranje po statusu tako da mora imati sve odabrane statuse koje korisnik postavi
        if ($request->has('health_statuses') && $request->health_statuses !== null) {
            foreach ($request->health_statuses as $healthstatusID) {
                $query->whereHas('healthstatuses', function ($q) use ($healthstatusID) {//definiranje relacije između dog i healthstatus(model dog je vezan sa healthstatuses isto i za karaktersitike)
                    $q->where('health_statuses.id', $healthstatusID);
                });
            }

        }

        // Filtriranje po pasmini
        if ($request->has('breed_id') && $request->breed_id !== null) {
            //u filter query dodaj provjeru pripada li pas toj pasmini
            $query->where('breed_id', $request->breed_id);
        }
        if ($request->has('gender_id') && $request->gender_id !== null) {
            $query->where('gender_id', $request->gender_id);
        }

        // Filtriranje po lokaciji
        if ($request->has('location') && $request->location !== null) {
            $query->where('location', $request->location);
        }

        // Filtriranje po statusu udomljavanja
        if ($request->has('is_adopted') && $request->is_adopted !== null) {
            $query->where('is_adopted', $request->is_adopted);
        }
        if ($request->has('sort_by') && $request->sort_by !== null) {
            $sortDirection = $request->input('sort_direction', 'asc');
            $query->orderBy('name', $sortDirection);
        }
        // Dohvati filtrirane pse
        $dogs = $query->get();
        return view('user.showAllDogs', compact('dogs', 'breeds', 'user', 'characteristics', 'healthstatus', 'genders'));
    }

}
