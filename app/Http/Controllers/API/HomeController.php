<?php

namespace App\Http\Controllers\API;

use App\ClientImage;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\PageBox;
use App\Option;

class HomeController extends Controller
{
    public function data()
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

        $baseUrl = url('/');

        return compact('baseUrl', 'banner', 'howItWorks', 'investments', 'clientImages', 'home_text1', 'home_text2', 'home_text3', 'faq_title', 'faq_description', 'home_text5', 'faqs');
    }
}
