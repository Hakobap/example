<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HomeTextsRequest;
use App\Http\Requests\SettingsRequest;
use App\Option;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * @var Option
     */
    protected $model;

    public function __construct(Option $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $model = $this->model;

        return view('admin.settings.index', compact('model'));
    }

    public function indexStore(SettingsRequest $request)
    {
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            // $extension = $file->getClientOriginalExtension();
            $fileName = 'logo.png';
            $file_path = 'assets/site/settings/'  . $fileName;
            $destinationPath = 'assets/site/settings/';

            if (is_file(public_path($file_path))) {
                unlink(public_path($file_path));
            }

            $file->move($destinationPath, $fileName);
        }

        return redirect()->back()->with('success', 'Form Data Successfully Saved!');
    }

    public function home()
    {
        $model = $this->model;

        return view('admin.home.additional', compact('model'));
    }

    public function homeStore(HomeTextsRequest $request)
    {
        Option::setItem('home_text1', $request->home_text1);
        Option::setItem('home_text2', $request->home_text2);
        Option::setItem('faq_title', $request->home_text3);
        Option::setItem('faq_description', $request->home_text4);
        Option::setItem('home_text5', $request->home_text5);

        return redirect()->back()->with('success', 'Form Data Successfully Saved!');
    }
}
