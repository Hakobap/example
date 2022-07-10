<?php

namespace App\Http\Controllers\User;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\addPositionRequest;
use App\Http\Requests\Employee\bulkRequest;
use App\Http\Requests\Employee\EmployeeStore;
use App\Http\Requests\Employee\Step1;
use App\Http\Requests\Employee\Step2;
use App\Http\Requests\Employee\Step3;
use App\Http\Requests\Employee\Step4;
use App\Http\Requests\Employee\Step5;
use App\Http\Requests\Employee\Step6;
use App\Models\Country;
use App\Models\EmployeeAction;
use App\Models\PayRate;
use App\UserPosition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManagerStatic as Image;

class EmployeeController extends Controller
{
    protected $isExistPosAndSites;

    public function rosteringDelete($id)
    {
        $this->deleteEmployeeById($id);

        return back();
    }

    public function employeeStore($id = null, EmployeeStore $request)
    {
        return $this->saveEmployee($id, $request, function ($user) use ($request) {
            $payRate = $user->payRate ?: new PayRate();
            $success = $payRate->fill(array_merge($request->all(), ['user_id' => $user->id]))->save();

            if ($success && $request->hasFile('photo')) {
                // Delete the old photo
                $user->deletePhoto();

                $image = $request->file('photo');
                $filename = time() . '_' . $image->getClientOriginalName();

                list($width, $height) = getimagesize($image->getRealPath());

                $new_width = 100;
                $new_height = ($new_width / $width) * $height;
                $new_image = public_path('images/user/' . $filename);

                Image::make($image->getRealPath())
                    ->resize($new_width, $new_height)
                    ->save($new_image);

                $user->photo = $filename;
                $user->save();
            }

            return $success;
        });
    }

    public function addPosition(addPositionRequest $request)
    {
        $model = new UserPosition();

        $data = ['user_id' => auth()->id(), 'value' => $request->position];

        $exist = (bool)$model->where($data)->count();

        if ($exist === true) {
            return ['success' => false, 'message' => 'The position has already been taken.'];
        }

        $success = $model->fill($data)->save();

        return ['success' => $success, 'data' => $model];
    }

    public function bulkAction(bulkRequest $request)
    {
        $data = [
            'app' => env('APP_NAME'),
            'name' => auth()->user()->first_name,
            'email' => auth()->user()->email,
            'company' => auth()->user()->company
        ];

        DB::beginTransaction();

        try {
            foreach ($request->employees as $employeeId) {
                if ($request->action == 'invite') {
                    // Sent mail to employee
                    $data['inviteUrl'] = route('employee.accept-invite', $inviteKey = uniqid());
                    $data['PIN'] = rand(1000, 9999);
                    Mail::send('emails.employee.invite', $data, function ($message) use ($data, $inviteKey, $employeeId) {
                        $employee = Employee::where(['id' => $employeeId, 'parent_id' => auth()->id()])->firstOrFail();
                        $employee->invited = 1;
                        $employee->invite_key = $inviteKey;
                        $employee->PIN = $data['PIN'];
                        $employee->save();

                        $message->subject(sprintf('Setup your %s account for %s s business', $data['app'], $data['company']));
                        $message->from($data['email'], $data['name']);
                        $message->to($employee->email);
                    });
                } elseif ($request->action == 'discard') {
                    // Delete the employee
                    $this->deleteEmployeeById($employeeId);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
        }

        return back();
    }

    /// step-by-step validation

    public function step1($id = null, Step1 $request)
    {
        return ['success' => true];
    }

    public function step2($id = null, Step2 $request)
    {
        return ['success' => true];
    }

    public function step3($id = null, Step3 $request)
    {
        return ['success' => true];
    }

    public function step4($id = null, Step4 $request)
    {
        return ['success' => true];
    }

    public function step5($id = null, Step5 $request)
    {
        return ['success' => true];
    }

    public function step6($id = null, Step6 $request)
    {
        return ['success' => true];
    }


    ############################################################################################# additional functions|methods


    /**
     * Saving new employee general information in db
     *
     * The callback need for save the user additional information
     *
     * @param null $id
     * @param $request
     * @param callable|null $callback
     * @return array
     */
    public function saveEmployee($id = null, $request, callable $callback = null)
    {
        DB::beginTransaction();

        try {
            $user = $this->getEmployeeById($id);

            $user->parent_id = auth()->id();

            if ($request->date_of_birth) {
                Carbon::parse($request->date_of_birth)->format('Y-m-d');
            }

            $request->hired_date = Carbon::parse($request->hired_date ?: Carbon::now())->format('Y-m-d');

            if ($id) {
                $success = $user->fill(
                    array_merge($request->except('photo'), ['password' => Hash::make($request->password ? $request->password : $user->password)])
                )->save();
            } else {
                $success = $user->fill(array_merge($request->except('photo'), ['password' => Hash::make($request->password)]))->save();
            }

            $this->addEmployeeActions($user->id, $request);

            if ($success === true && $callback !== null) {
                $success = $callback($user);
            }

            $success ? DB::commit() : DB::rollBack();

            return ['success' => $success];
        } catch (\Exception $e) {
            DB::rollBack();

            // dd($e);

            return ['success' => false, 'message' => 'Oops! please check the filled out fields.'];
        }
    }

    public function addEmployeeActions($user_id, $request)
    {
        EmployeeAction::where('user_id', $user_id)->delete();

        foreach ($request->site_id as $site_id) {
            foreach ($request->position_id as $position_id) {
                EmployeeAction::create(['user_id' => $user_id, 'user_site_id' => $site_id, 'user_position_id' => $position_id]);
            }
        }
    }

    public function form(Request $request)
    {
        $id = intval($request->id);

        $employeeModel = $this->getEmployeeById($id);

        $sitesForEmployees = auth()->user()->sites;

        $positions = auth()->user()->positions;

        $countries = Country::all();

        return view('user.__user-add-box', compact('id', 'sitesForEmployees', 'positions', 'countries', 'employeeModel'));
    }

    public function getEmployeeById($id)
    {
        if ($employeeModel = Employee::find(intval($id))) {
            $employeeModel->newRecord = false;
            if ($employeeModel->parent_id == null && $employeeModel->id != auth()->id()) {
                $employeeModel = new Employee();
                $employeeModel->newRecord = true;
            }
        } else {
            $employeeModel = new Employee();
            $employeeModel->newRecord = true;
        }

        return $employeeModel;
    }

    public function deleteEmployeeById($id)
    {
        $employee = Employee::where(['id' => $id, 'parent_id' => auth()->id()])->firstOrFail();

        $employee->deletePhoto();

        return $employee->delete();
    }
}
