<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class SessionSteps
{
    private static $instance = null;

    public $activeStep = 1;
    /**
     * @var int max steps quantity.
     */
    public $max = 5;

    private function __construct()
    {
    }

    public function init()
    {
        for ($i = 1; $i <= $this->max; $i++) {
            $this->setActiveStep($i);
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->init();
        }

        return self::$instance;
    }

    /**
     * @param int $activeStep
     */
    public function setActiveStep($i)
    {
        if ($i == 5 && !empty($this->getStep(5))) {
            $this->activeStep = 5;
        } elseif (!empty($this->getStep($i))) {
            $this->activeStep = $i + 1;
        }
    }

    public function setMax($max)
    {
        $this->max = $max;

        return $this->save();
    }

    public function getStep($number, $default = [])
    {
        return Session::get('step' . $number, $default);
    }

    public function getValue($number, $key, $default = '')
    {
        $step = $this->getStep($number);

        return isset($step[$key]) ? $step[$key] : $default;
    }

    public function setStep($number, $value = [])
    {
        Session::put('step' . $number, $value);

        return $this->save();
    }

    public function deleteStep($number, $ignoreNextItemChecking = false)
    {
        if ($ignoreNextItemChecking === true) {
            if (!empty($this->getStep($number + 1))) {
                Session::put('step' . $number, []);
            }
        } elseif ($ignoreNextItemChecking === false) {
            Session::put('step' . $number, []);
        }

        if ($number == 1) {
            Session::put('step' . $number, []);
        }

        return $this->save();
    }

    public function deleteAll()
    {
        $this->activeStep = 1;
        Session::put('active-reg-step', 1);

        for ($i = 1; $i <= $this->max; $i++) {
            $this->deleteStep($i);
        }

        return $this->save();
    }

    public function getLastActiveStepNumber()
    {
        $activeStep = $this->getStep($this->activeStep);
        $prevStep = $this->getStep($this->activeStep - 1);
        if (empty($activeStep) && !empty($prevStep)) {
            $this->activeStep += 1;
            return $this->activeStep;
        } elseif ($this->activeStep > 2) {
            $this->activeStep -= 1;
            return $this->getLastActiveStepNumber();
        }

        return 1;
    }

    public function save()
    {
        Session::save();

        return $this;
    }
}