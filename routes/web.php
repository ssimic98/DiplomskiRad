<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdoptionQuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteDogController;
use App\Http\Controllers\AdoptionAnswersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
Auth::routes(
    ['verify'=> true]
);

//Funkcija index redirecta ovisno o roli
Route::get('/', [HomeController::class,'index']);
Route::middleware('guest')->group(function()
{
    Route::get('password/reset',[ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
});
//Rute za email verifikaciju
Route::get('email/verify', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/mail/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth'])
    ->name('verification.verify');

Route::post('email/resend', [VerificationController::class, 'resend'])
    ->middleware('auth')
    ->name('verification.resend');
//Admin rute
Route::middleware(['auth','verified' ,'role:admin'])->group(function() {
    //Rute za prikaz ukupnog broja pasa i udomljenih pasa te prikaz broja korisnika sa rolom shelter i user
    Route::get('admin/dashboard', [AdminController::class, 'adminDashboardUsersAndDogs'])->name('admin.dashboard.dashboard');
    Route::get('admin/users', [AdminController::class, 'showAllUsers'])->name('admin.user.user');
    Route::delete('admin/user/{userID}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    ///Zdravstevni status rute
    Route::get('admin/health-statuses', [AdminController::class, 'showHealthStatus'])->name('admin.health_status.showHealthStatus');
    Route::post('admin/health-statuses', [AdminController::class, 'storeHealthStatus'])->name('admin.health_status.storeHealthStatus');
    Route::put('admin/health-statuses/{healthStatus}', [AdminController::class, 'updateHealthStatus'])->name('admin.health_status.updateHealthStatus');
    Route::delete('admin/health-statuses/{healthStatus}', [AdminController::class, 'deleteHealthStatus'])->name('admin.health_status.deleteHealthStatus');

    ///Pasmina rute
    Route::get('admin/breeds', [AdminController::class, 'showBreed'])->name('admin.breed.showBreed');
    Route::post('admin/breeds', [AdminController::class, 'storeBreed'])->name('admin.breed.storeBreed');
    Route::put('admin/breeds/{breed}', [AdminController::class, 'updateBreed'])->name('admin.breed.updateBreed');
    Route::delete('admin/breeds/{breed}', [AdminController::class, 'deleteBreed'])->name('admin.breed.deleteBreed');

    ///Spol rute
    Route::get('admin/genders', [AdminController::class, 'showGender'])->name('admin.gender.showGender');
    Route::post('admin/genders', [AdminController::class, 'storeGender'])->name('admin.gender.storeGender');
    Route::put('admin/genders/{gender}', [AdminController::class, 'updateGender'])->name('admin.gender.updateGender');
    Route::delete('admin/genders/{gender}', [AdminController::class, 'deleteGender'])->name('admin.gender.deleteGender');

    ///Karakteristika rute
    Route::get('admin/characteristics', [AdminController::class, 'showCharacteristic'])->name('admin.characteristic.showCharacteristic');
    Route::post('admin/characteristics', [AdminController::class, 'storeCharacteristic'])->name('admin.characteristic.storeCharacteristic');
    Route::put('admin/characteristics/{characteristic}', [AdminController::class, 'updateCharacteristic'])->name('admin.characteristic.updateCharacteristic');
    Route::delete('admin/characteristics/{characteristic}', [AdminController::class, 'deleteCharacteristic'])->name('admin.characteristic.deleteCharacteristic');
});

Route::get('/test-url', function () {
    return config('app.url');
});
//Shelter rute
Route::middleware(['auth','verified','role:shelter'])->group(function(){
    
    Route::get('shelter/showadoption',[AdoptionQuestionController::class,'showAdoption'])->name('shelter.dogs.adoption');
    Route::get('shelter/showadoption/questions/{adoptionID}',[AdoptionQuestionController::class,'showAdoptionQuestionsDetails'])->name('shelter.dogs.adoptionDetail');

    //Rute za stvaranje i brisanje obrazaca
    Route::get('shelter/create/adoptionquestions',[AdoptionQuestionController::class,'createQuestions'])->name('shelter.dogs.adoptionsQuestionCreate');
    Route::post('shelter/adoptions',[AdoptionQuestionController::class,'storeQuestions'])->name('shelter.dogs.storeAdoptionQuestions');
    Route::delete('shelter/adoptions/delete/questions/{adoptionID}',[AdoptionQuestionController::class,'deleteAdoptionQuestions'])->name('shelter.dogs.deleteAdoption');

    //Rute za pregled zahtjeva obrazaca kao i za prihvacanje ili odbijanje zahtjeva za udomljavanje
    Route::get('shelter/alladoptionrequests',[AdoptionAnswersController::class,'showAllAdoptionRequests'])->name('shelter.dogs.showAdoptionRequests');
    Route::get('shelter/dogs/adoptionanswersdetail/{answerID}',[AdoptionAnswersController::class,'showAdoptionDetails'])->name('shelter.dogs.adoptionAnswersDetail');
    Route::post('shelter/showadoptionanswers/accpet/{answerID}',[AdoptionAnswersController::class,'acceptAnswer'])->name('shelter.dogs.adoptionAnswersAccept');
    Route::post('shelter/showadoptionanswers/reject/{answerID}',[AdoptionAnswersController::class,'rejectAnswer'])->name('shelter.dogs.adoptionAnswersReject');

    //Rute za stvaranje, ažuriranje prikaz i brisanje pasa
    Route::get('shelter/showdogs',[DogController::class,'shelterShowDogs'])->name('shelter.dogs.showDogs');
    Route::get('shelter/createdog',[DogController::class,'createDog'])->name('shelter.dogs.createDog');
    Route::post('shelter/dogs',[DogController::class,'storeDog'])->name('shelter.dogs.storeDog');
    Route::get('shelter/editdog/{dog}/edit', [DogController::class, 'editDog'])->name('shelter.dogs.editDog');
    Route::put('shelter/{dog}/updatedog', [DogController::class, 'updateDog'])->name('shelter.dogs.updateDog');
    Route::delete('shelter/deletedog/{dog}', [DogController::class, 'deleteDog'])->name('shelter.dogs.deleteDog');
});

//User rute
Route::middleware(['auth','verified','role:user'])->group(function()
{
    //Rute kojima se korisniku prikazuju odgovoreni zahtjevi azila kao i prikaz statusa odgovorenog zahtjeva za udomljavanjem
    Route::get('user/adoption/answeredrequests',[UserController::class,'showAnsweredRequests'])->name('user.showAnsweredAdoptionRequests');
    Route::get('user/adoption/status/{answerID}',[UserController::class,'showAdoptionStatus'])->name('user.adoptionStatus');
    
    //Ruta za slanje zahtjeva za nekog psa
    Route::post('user/adoption/{dog}', [AdoptionAnswersController::class, 'store'])->name('user.submitAdoptionForm');

    //Ruta za prikaz svih pasa
    Route::get('user/showdogs',[DogController::class,'filterAndSort'])->name('user.showAllDogs');
    //Ruta za dohvaćanje forme obrasca za udomljavanje
    Route::get('user/adoption/{dog}',[UserController::class,'showAdoptionForm'])->name('user.adoptionForm');
    //Ruta za prikaz psa¸sa pojedinostima
    Route::get('user/showdogs/{dog}',[UserController::class,'showDog'])->name('user.showDog');

    //Rute za dohvaćanje koje je psa dodaoo favorita kao i za uklanjanje i dodavanje psa među favorite
    Route::get('user/favoritedogs',[UserController::class,'showFavoriteDogs'])->name('user.showfavoriteDogs');
    Route::post('user/favorite-dog',[FavoriteDogController::class,'AddFavorite']);
    Route::delete('user/favorite-dog',[FavoriteDogController::class,'RemoveFavorite']);

});

Route::middleware(['auth','role:user,shelter'])->group(function()
{
    //Ruta kojom se sve poruke označavaju sa pročitane
    Route::get('mark-as-read',[AdoptionAnswersController::class,'markAsRead'])->name('mark-as-read');
});

