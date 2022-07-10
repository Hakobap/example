<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HomeBannerRequest;
use App\Models\PageBox;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class BannersController extends Controller
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

    public function home()
    {
        $model = $this->getModelWithoutFail(PageBox::BANER);

        return view('admin.home.banner', compact('model'));
    }

    public function homeStore(HomeBannerRequest $request)
    {
        $model = $this->getModelWithoutFail(PageBox::BANER);
        $model->fillable(['title', 'text', 'extra', 'file']);
        $model->category_id = 1;

        $header_old_image = $model->file;

        if ( $model->fill($request->all())->save() ) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(20) . '.' . $extension;
                $file_path = 'assets/site/banners/'  . $fileName;
                $destinationPath = 'assets/site/banners/';
                $file->move($destinationPath, $fileName);
                $model->file = $file_path;
                $model->save();

                if (is_file(public_path($header_old_image))) {
                    unlink(public_path($header_old_image));
                }
            }
        }

        return redirect()->back()->with('success', 'Form Data Successfully Saved!');
    }
}
