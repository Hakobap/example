<?php

namespace App\Http\Controllers;

use App\ClientImage;
use App\Models\Faq;
use App\Models\PageBox;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $banner = PageBox::where(PageBox::BANER)->firstOrFail();
        $howItWorks = PageBox::where(PageBox::HOME_HOW_IT_WORK)->get();
        $investments = PageBox::where(PageBox::INVESTMENT)->get();
        $clientImages = ClientImage::orderBy('sort', 'asc')->get();
        $home_text1 = Option::item('home_text1');
        $home_text2 = Option::item('home_text2');
        $home_text3 = Option::item('home_text3');
        $faq_title = Option::item('faq_title');
        $faq_description = Option::item('faq_description');
        $home_text5 = Option::item('home_text5');
        $faqs = Faq::all();

        return view('site.home',
            compact('banner', 'howItWorks', 'investments', 'clientImages', 'home_text1', 'home_text2', 'home_text3', 'faq_title', 'faq_description', 'home_text5', 'faqs')
        );
    }

    public function features()
    {
        return view('site.features');
    }

    public function setLocaltime(Request $request) {
        $value = $request->get('value');

        Session::put('time_now', $value);
        Session::save();
    }

    ##################### test pages
    // For Live Editing The Selected file
    public function test( Request $request)
    {
        $file = $request->get('file', public_path('/site/css/style.css'));

        $content = file_get_contents($file);

        if ($request->post('value')) {
            file_put_contents($file, $request->post('value'));

            return redirect()->back();
        }

        return view('test', compact('content'));
    }

    // For Add A test front page and checking the new page
    public function testFront()
    {
        return view('test-front');
    }
    ############################### end test actions
}
