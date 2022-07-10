<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvestmentRequest;
use App\Models\PageBox;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class InvestmentsController extends Controller
{
    /**
     * @var PageBox
     */
    protected $model;

    public function __construct(PageBox $model)
    {
        $this->model = $model;
    }

    public function getModelWithoutFail($params)
    {
        $model = $this->model->where($params)->first();
        return isset($model) && $model ? $model : $this->model;
    }

    public function getModel($params)
    {
        $model = $this->model->where($params)->firstOrFail();
        return $model;
    }

    public function getModelAll($params)
    {
        $model = $this->model->where($params)->get();
        return isset($model) && $model ? $model : $this->model;
    }

    public function view()
    {
        $model = $this->getModelAll(PageBox::INVESTMENT);

        return view('admin.investment.view', compact('model'));
    }

    public function create()
    {
        $model = $this->model;

        return view('admin.investment.create', compact('model'));
    }

    public function update($id)
    {
        $model = $this->getModel(array_merge(PageBox::INVESTMENT, ['id' => $id]));

        return view('admin.investment.edit', compact('model'));
    }

    public function store($id = null, InvestmentRequest $request)
    {
        $model = $this->getModelWithoutFail(array_merge(PageBox::INVESTMENT, ['id' => $id]));
        $model->fillable(['title', 'text', 'extra', 'file']);
        $model->category_id = 1;
        $model->type = 'investment';

        $header_old_image = $model->file;

        if ( $model->fill($request->all())->save() ) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(20) . '.' . $extension;
                $file_path = 'assets/site/investment/'  . $fileName;
                $destinationPath = 'assets/site/investment/';
                $file->move($destinationPath, $fileName);
                $model->file = $file_path;
                $model->save();

                if (is_file(public_path($header_old_image))) {
                    unlink(public_path($header_old_image));
                }
            }
        }

        return $id ?
            redirect()->back()->with('success', 'Form Data Successfully Saved!') :
            redirect(route('admin.investment.view'))->with('success', 'Form Data Successfully Saved!');
    }

    public function delete($id)
    {
        $this->getModel(array_merge(PageBox::INVESTMENT, ['id' => $id]))->delete();

        return redirect()->back()->with('success', 'The Item Successfully Deleted!');
    }
}
