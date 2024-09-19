<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthStatus;
use App\Models\Breed;
use App\Models\Characteristic;
use App\Models\Gender;
use App\Models\User;
use App\Models\Dog;
class AdminController extends Controller
{
    ////////////HealthStatus CRUD
    public function showHealthStatus()
    {
        $healthStatuses=HealthStatus::all();
        return view('admin.health_status.showHealthStatus',compact('healthStatuses'));
    }

    public function storeHealthStatus(Request $request)
    {
        $request->validate([
            'status'=>'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž\s]+$/u|max:255|unique:health_statuses,status'
        ], [
            'status.regex' => 'Zdravstveni status može sadržavati samo slova',
            'status.unique'=> 'Zdravstveni status već postoji',
        ]);

        HealthStatus::create($request->all());

        return redirect()->route('admin.health_status.showHealthStatus')->with('success','Zdravstveni status dodan');
    }
    public function updateHealthStatus(Request $request,HealthStatus $healthStatus)
    {
        $request->validate(['status'=>'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž\s]+$/u|max:255|unique:health_statuses,status,'.$healthStatus->id],[
            'status.regex'=>'Zdravstveni status može sadržavati samo slova',
            'status.unique'=>'Zdravstveni status već postoji',
        ]);
        $healthStatus->update([
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('admin.health_status.showHealthStatus')->with('success','Zdravstveni status ažuriran');
    }

    public function deleteHealthStatus(HealthStatus $healthStatus)
    {
        $healthStatus->delete();
        return redirect()->route('admin.health_status.showHealthStatus')->with('sucess','Zdravstveni status obrisan');
    }


    ////////////Breed crud
    public function showBreed()
    {
        $breeds=Breed::all();
        return view('admin.breed.showBreed',compact('breeds'));
    }
    public function storeBreed(Request $request)
    {
        $request->validate([
            'breed' => 'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž\s]+$/u|max:255|unique:breeds,breed'
        ], [
            'breed.regex' => 'Pasmina može sadržavati samo slova',
            'breed.unique'=> 'Ova pasmina već postoji',
        ]);
        Breed::create($request->all());

        return redirect()->route('admin.breed.showBreed')->with('success', 'Pamsina dodana');
    }

    public function updateBreed(Request $request, Breed $breed)
    {
        $request->validate([
            'breed' => 'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž\s]+$/u|max:255|unique:breeds,breed,' . $breed->id,
        ], [
            'breed.regex' => 'Pasmina može sadržavati samo slova',
            'breed.unique'=> 'Ova pasmina već postoji',
        ]);

        $breed->update([
            'breed' => $request->input('breed'),
        ]);

        return redirect()->route('admin.breed.showBreed')->with('success', 'Pasmina ažurirana');
    }

    public function deleteBreed(Breed $breed)
    {
        $breed->delete();
        return redirect()->route('admin.breed.showBreed')->with('success','Pasmina obrisana');
    }



    ////////////Gender crud
    public function showGender()
    {
        $genders=Gender::all();
        return view('admin.gender.showGender',compact('genders'));
    }

    public function storeGender(Request $request)
    {
        $request->validate([
            'gender'=>'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u|max:255|unique:genders,gender'
        ],[
            'gender.regex'=>'Spol može sadržavati samo slova',
            'gender.unique'=>'Spol već postoji',
        ]);

        Gender::create($request->all());

        return redirect()->route('admin.gender.showGender')->with('success','Spol dodan');
    }
    public function updateGender(Request $request,Gender $gender)
    {
        $request->validate(['gender'=>'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u|max:255|unique:genders,gender,'.$gender->id],[
            'gender.regex'=>'Spol može sadržavati samo slova',
            'gender.unique'=>'Spol već postoji',
        ]);
        $gender->update([
            'gender'=>$request->input('gender'),
        ]);
        return redirect()->route('admin.gender.showGender')->with('success','Spol ažuriran');
    }

    public function deleteGender(Gender $gender)
    {
        $gender->delete();
        return redirect()->route('admin.gender.showGender')->with('success','Spol obrisan');
    }


    ////////////Characteristic crud
    public function showCharacteristic()
    {
        $characteristics=Characteristic::all();
        return view('admin.characteristic.showCharacteristic',compact('characteristics'));
    }

    public function storeCharacteristic(Request $request)
    {
        $request->validate([
            'characteristic'=>'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž\s]+$/u|max:255|unique:characteristics,characteristic'
        ],[
            'characteristic.regex'=>'Karakteristika može sadržavati samo slova',
            'characteristic.unique'=>'Karakteristika već postoji',
        ]);

        Characteristic::create($request->all());

        return redirect()->route('admin.characteristic.showCharacteristic')->with('success','Karakteristika dodana');
    }
    public function updateCharacteristic(Request $request,Characteristic $characteristic)
    {
        $request->validate(['characteristic'=>'required|string|regex:/^[a-zA-ZčćČĆžšŽŠĐđDždž]+$/u|max:255|unique:characteristics,characteristic,'.$characteristic->id]);
        $characteristic->update([
            'characteristic'=>$request->input('characteristic'),
        ],[
            'characteristic.regex'=>'Karakteristika može sadržavati samo slova',
            'characteristic.unique'=>'Karakteristika već postoji',
        ]);
        return redirect()->route('admin.characteristic.showCharacteristic')->with('success','Karakteristika ažurirana');
    }

    public function deleteCharacteristic(Characteristic $characteristic)
    {
        $characteristic->delete();
        return redirect()->route('admin.characteristic.showCharacteristic')->with('success','Karakteristika obrisana');
    }

    public function adminDashboardUsersAndDogs()
    {
        $countUser=[
            'user'=>User::where('role','user')->count(),
            'shelter'=>User::where('role','shelter')->count(),
        ];

        $adoptedDogs=Dog::where('is_adopted',true)->count();
        $totalDogs=Dog::count();
        return view('admin.dashboard.dashboard',compact('countUser','adoptedDogs','totalDogs'));
    }
    public function showAllUsers()
    {
        $users=User::where('role','!=','admin')->get();
        return view('admin.user.user',compact('users'));
    }

    public function deleteUser($userID)
    {
        $user=User::findOrFail($userID);
        $user->delete();
        return redirect()->back();
    }
}
