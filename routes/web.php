<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProspectsController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\DemografiController;
use App\Http\Controllers\NotInterestedController;
use App\Http\Controllers\RoasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/login', [LoginController::class, 'login']);
Route::post('/postLogin', [LoginController::class, 'postLogin']);
// Route::get('/register', [LoginController::class, 'register']);
// Route::post('/register/create', [LoginController::class, 'create']);
Route::get('/logout', [LoginController::class, 'logout']);

Auth::routes();

Route::get('/home', [
    App\Http\Controllers\HomeController::class,
    'index',
])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::match(['get', 'post'], '/', [HomeController::class, 'index'])->name('dashboard.home');
    Route::get('/index', [HomeController::class, 'index'])->name('dashboard.index');

    Route::get('/prospects', [ProspectsController::class, 'index'])->name('prospect.index');
    Route::post('/prospects', [ProspectsController::class, 'filter'])->name('prospect.filter');
    Route::get('/prospects/download', [ProspectsController::class, 'excel'])->name('prospect.download');
    Route::delete('/prospects/{ProspectID}', [
        ProspectsController::class,
        'delete',
    ])->name('prospect.delete');
    Route::get('/prospects/create', [ProspectsController::class, 'create'])->name('prospect.create');
    Route::get('/prospects/create-manual', [ProspectsController::class, 'createManual'])->name('prospect.create-manual');
    Route::post('/prospects/create', [ProspectsController::class, 'store'])->name('prospect.store');
    Route::post('/prospects/create-manual', [ProspectsController::class, 'storeManual'])->name('prospect.store-manual');
    Route::get('/prospects/sewa/create', [ProspectsController::class, 'sewa'])->name('prospect.sewa');
    Route::post('/prospects/sewa/create', [
        ProspectsController::class,
        'SewaStore',
    ])->name('prospect.sewastore');
    Route::get('/prospects/edit/{ProspectID}', [
        ProspectsController::class,
        'edit',
    ])->name('prospect.edit');
    Route::post('/prospects/update/{ProspectID}', [
        ProspectsController::class,
        'update',
    ])->name('prospect.update');

    Route::get('/prospects/{KodeAgent}/{KodeSales}', [
        ProspectsController::class,
        'prospect_sales',
    ])->name('prospect.sales');
    Route::post('/prospects/sales', [
        ProspectsController::class,
        'prospect_sales_move',
    ])->name('prospect.salesmove');

    Route::post('/prospect/verifikasi/{ProspectID}', [
        ProspectsController::class,
        'prospect_verifikasi',
    ])->name('prospect.verifikasi');

    Route::post('/filter', [HomeController::class, 'filterChart'])->name('dashboard.filter');

    Route::get('prospect/Process', [HomeController::class, 'process'])->name('dashboard.process');
    Route::get('prospect/Closing', [HomeController::class, 'Closing'])->name('dashboard.closing');
    Route::get('prospect/NotInterested', [
        HomeController::class,
        'notInterested',
    ])->name('dashboard.notinterested');

    Route::get('prospect/history', [ProspectsController::class, 'history'])->name('prospect.history');

    Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/projects/create', [ProjectController::class, 'create']);
    Route::post('/projects/create', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/projects/details/{KodeProject}', [
        ProjectController::class,
        'edit',
    ])->name('project.edit');
    Route::post('/projects/update/{KodeProject}', [
        ProjectController::class,
        'update',
    ])->name('project.update');
    Route::delete('/projects/{KodeProject}', [
        ProjectController::class,
        'destroy',
    ])->name('project.destroy');

    Route::get('/agent', [AgentController::class, 'index'])->name('agent.index');
    Route::post('/agent/active/{KodeAgent}', [AgentController::class, 'active'])->name('agent.active');
    Route::post('/agent/nonactive/{KodeAgent}', [AgentController::class, 'nonactive'])->name('agent.nonactive');
    Route::get('/agent/prospect/{KodeAgent}', [
        AgentController::class,
        'prospect',
    ])->name('agent.prospect');
    Route::post('/agent/prospect', [AgentController::class, 'prospectmove'])->name('agent.prospectmove');
    Route::post('/agent', [AgentController::class, 'filter'])->name('agent.filter');
    Route::get('/agent/create', [AgentController::class, 'create'])->name('agent.create');
    Route::post('/agent/create', [AgentController::class, 'store'])->name('agent.store');
    Route::post('/agent/update/{KodeAgent}', [
        AgentController::class,
        'update',
    ])->name('agent.update');
    Route::delete('/agent/{KodeAgent}/{UsernameKP}', [
        AgentController::class,
        'delete',
    ])->name('agent.delete');

    Route::get('/getsales', [AgentController::class, 'getSales'])->name('agent.getsales');
    Route::get('/get_agent', [AgentController::class, 'get_agent'])->name('agent.getagent');

    Route::get('/roas', [RoasController::class, 'index'])->name('roas.index');
    Route::post('/roas/create', [RoasController::class, 'store'])->name('roas.store');
    Route::post('/roas/update/{id}', [RoasController::class, 'update'])->name('roas.update');
    Route::delete('/roas/delete/{id}', [RoasController::class, 'destroy'])->name('roas.destroy');

    Route::get('/demografi', [DemografiController::class, 'index'])->name('demografi.index');
    Route::get('/getkota', [DemografiController::class, 'getkota'])->name('demografi.getkota');

    Route::get('/notInterested', [NotInterestedController::class, 'index'])->name('notinterested.index');
    Route::resource('unit', UnitController::class);


    Route::get('/agent/sales/{KodeAgent}', [SalesController::class, 'index'])->name('agent.sales.index');
    Route::get('/sales/create/{KodeAgent}', [SalesController::class, 'create'])->name('agent.sales.create');
    Route::get('history/{KodeSales}', [SalesController::class, 'history'])->name('agent.sales.history');
    Route::post('/sales/create/{KodeAgent}', [SalesController::class, 'store'])->name('agent.sales.store');
    Route::post('/sales/update/{KodeAgent}', [
        SalesController::class,
        'update',
    ])->name('agent.sales.update');
    Route::delete('/sales/{KodeSales}', [SalesController::class, 'delete'])->name('agent.sales.delete');
    Route::post('/sales/{KodeAgent}/{KodeSales}/{UrutAgentSales}', [
        SalesController::class,
        'nonactive',
    ])->name('agent.sales.nonactive');
    Route::post('/sales/{KodeAgent}/{KodeSales}', [SalesController::class, 'active'])->name('agent.sales.active');

    Route::get('find_hp', [ProspectsController::class, 'find_hp']);


});

    Route::get('/reset', function () {
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
    });