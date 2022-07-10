<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

/**
 * Class FaqController
 * @package App\Http\Controllers\Admin
 */
class FaqController extends Controller
{
    /**
     * Faq list page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = $this->model()->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            $view = view('admin.faq.data', compact('model'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('admin.faq.index', compact('model'));
    }

    /**
     * Create faq page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = $this->model();

        return view('admin.faq.create', compact('model'));
    }

    /**
     * Update faq page.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $model = $this->model(intval($request->id));
        return view('admin.faq.update', compact('model'));
    }


    /**
     * Remove faq.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function remove(Request $request)
    {
        $this->model(intval($request->id))->delete();

        return redirect('/admin/faq');
    }


    /**
     * Save faq.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $model = $this->model(intval($request->id));
        $model->fill($request->toArray());
        $validator = $model->validation($request);
        if(!$validator->fails()) {
            if ($model->save()) {
                $request->session()->flash('alert-success', 'Form successful saved!');
                return redirect('/admin/faq');
            }
        }
        return redirect('/admin/faq/' . ($request->id ? 'update/' . $request->id : 'create'));
    }

    /**
     * The Faq model
     *
     * @param int|null $id
     * @return Faq
     */
    public function model($id = null)
    {
        return is_int($id) && $id ? Faq::find($id) : new Faq();
    }
}