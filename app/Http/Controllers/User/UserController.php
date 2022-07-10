<?php

namespace App\Http\Controllers\User;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteCheckerRequest;
use App\Http\Requests\SiteRequest;
use App\Models\Country;
use App\Models\Task;
use App\User;
use App\UserSite;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $filterParams = [];

        if (intval($request->site_id)) {
            $filterParams['site_id'] = intval($request->site_id);
        }

        $employeeModel = new Employee();

        $rosters = $employeeModel->getRosters();

        $availableOfStaff = $employeeModel->getStaffAvailability($filterParams);

        $sites = auth()->user()->sites;

        $query = Task::where('user_id', auth()->id());

        // updating query by request date
        User::tasksFromRequestQuery($query);

        $tasks = $query->get();

        $diagramData = new \stdClass();
        $diagramData->x = 0;
        $diagramData->y = 0;
        $diagram = [$diagramData];
        foreach ($tasks as $task) {
            $diagramData = new \stdClass();
            $diagramData->y = Task::getTaskAvailable($task->start_date, $task->end_date);
            $diagramData->label = $task->employee->first_name . ' ' . $task->employee->last_name;
            $diagram[] = $diagramData;
        }

        return view('user.dashboard', compact('tasks', 'diagram', 'rosters', 'availableOfStaff', 'sites'));
    }

    public function staff()
    {
        $employees = User::where('parent_id', auth()->id())->where('id', '!=', auth()->id())->with(['sites', 'positions'])->get();

        $employeeModel = new Employee();

        $rosters = $employeeModel->getRosters();

        $availableOfStaff = $employeeModel->getStaffAvailability();

        $query = Task::where('user_id', auth()->id());

        // updating query by request date
        User::tasksFromRequestQuery($query);

        $tasks = $query->get();

        $sitesForEmployees = auth()->user()->sites;

        $positions = auth()->user()->positions;

        $countries = Country::all();

        $employeeModel = new Employee();

        return view('user.staff', compact('employees', 'rosters', 'availableOfStaff', 'tasks', 'sitesForEmployees', 'positions', 'countries', 'employeeModel'));
    }

    // Sites actions

    public function sites()
    {
        $sites = UserSite::where('user_id', auth()->id())->get();

        $countries = Country::all();

        return view('user.sites', compact('sites', 'countries'));
    }

    public function deleteSite($id)
    {
        UserSite::where(['id' => $id, 'user_id' => auth()->id()])->firstOrFail()->delete();

        return back();
    }

    public function storeSite(SiteRequest $request)
    {
        $model = $request->id ? UserSite::where(['id' => $request->id, 'user_id' => auth()->id()])->firstOrFail() : new UserSite();

        $model->fillable(['user_id', 'country_id', 'value', 'address', 'state', 'postcode', 'city', 'phone'])->fill(array_merge($request->all(), ['user_id' => auth()->id()]))->save();

        return ['success' => true];
    }

    public function getSite(SiteCheckerRequest $request)
    {
        return ['success' => true, 'data' => UserSite::where(['id' => $request->id, 'user_id' => auth()->id()])->firstOrFail()];
    }
}
