<?php

namespace App\Http\Controllers;

use App\Http\Requests\Step1Request;
use App\Http\Requests\Step2Request;
use App\Http\Requests\Step3Request;
use App\Http\Requests\Step4Request;
use App\Http\Requests\Step5Request;
use App\Models\EmployeeAction;
use App\Services\SessionSteps;
use App\User;
use App\UserPosition;
use App\UserSite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StepsController extends Controller
{
    /**
     * @var SessionSteps
     */
    protected $sessionService;

    public function __construct()
    {
        $this->sessionService = SessionSteps::getInstance();
    }

    public function step1(Step1Request $request)
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'company', 'password', 'roster_start_time']);
        $data['password'] = Hash::make($data['password']);
        $this->sessionService->setStep(1, $data);

        return ['success' => true, 'company' => $data['company']];
    }

    public function step2(Step2Request $request)
    {
        if (empty($this->sessionService->getStep(1))) {
            return ['success' => false];
        }

        $data = $request->only(['site']);
        $this->sessionService->setStep(2, $data);

        return ['success' => true];
    }

    public function step3(Step3Request $request)
    {
        if (empty($this->sessionService->getStep(1)) ||
            empty($this->sessionService->getStep(2))) {
            return ['success' => false];
        }

        $data = $request->only(['position']);
        $this->sessionService->setStep(3, $data);

        return ['success' => true];
    }

    public function step4(Step4Request $request)
    {
        if (empty($this->sessionService->getStep(1)) ||
            empty($this->sessionService->getStep(2)) ||
            empty($this->sessionService->getStep(3))) {
            return ['success' => false];
        }

        $data = $request->only(['first_name', 'last_name', 'email', 'phone', 'site', 'position']);
        $this->sessionService->setStep(4, $data);

        return ['success' => true];
    }

    public function step5(Step5Request $request)
    {
        /// save in db

        $step1 = $this->sessionService->getStep(1);
        $step2 = $this->sessionService->getStep(2);
        $step3 = $this->sessionService->getStep(3);
        $step4 = $this->sessionService->getStep(4);

        if (empty($step1) || empty($step2) || empty($step3) || empty($step4)) {
            return ['success' => false];
        }

        DB::beginTransaction();

        try {
            $user = new User();
            $childUser = clone $user;
            $step1['verified'] = 1; // TODO auto verification for Employer need to add verification by email
            $user->fillable(['first_name', 'last_name', 'company', 'roster_start_time', 'phone', 'email', 'password', 'verified'])->fill($step1)->save();
            $childUser->parent_id = $user->id;
            $childUser->fillable(['first_name', 'last_name', 'company', 'roster_start_time', 'phone', 'email', 'password'])->fill(array_merge($step4, ['company' => '', 'roster_start_time' => '', 'password' => uniqid()]))->save();

            $ids = [];
            foreach ($this->sessionService->getValue(2, 'site') as $site) {
                $model = new UserSite();
                $model->fill(['user_id' => $user->id, 'value' => $site])->save();

                if (in_array($site, $this->sessionService->getValue(4, 'site'))) {
                    $ids[] = $model->id;
                }
            }

            foreach ($this->sessionService->getValue(3, 'position') as $position) {
                $model = new UserPosition();
                $model->fill(['user_id' => $user->id, 'value' => $position])->save();

                if (in_array($position, $this->sessionService->getValue(4, 'position'))) {
                    foreach ($ids as $id) {
                        EmployeeAction::create(['user_id' => $childUser->id, 'user_site_id' => $id, 'user_position_id' => $model->id]);
                    }
                }
            }

            $this->sessionService->deleteAll();

            DB::commit();

            Auth::login($user);
        } catch (\Exception $e) {
            DB::rollBack();

            return ['success' => false];
        }

        return ['success' => true, 'url' => route('user.dashboard')];
    }

    public function sites()
    {
        $sites = $this->sessionService->getValue(2, 'site');

        return ['success' => !empty($sites), 'data' => $sites];
    }

    public function positions()
    {
        $positions = $this->sessionService->getValue(3, 'position');

        return ['success' => !empty($positions), 'data' => $positions];
    }
}
