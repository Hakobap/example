<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Faq extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question', 'answer'
    ];

    private $rules = [
        'question' => 'required|min:4|max:255',
        'answer' => 'required|min:4|max:10000',
    ];

    /**
     * @param $data
     * @return Validator
     */
    public function validation($data)
    {
        $validator = Validator::make($data->all(), $this->rules);

        // Optionally customize this version using new ->after()
        $validator->after(function() use ($validator, $data) {
            // Do more validation
        });

        $validator->validate();

        return $validator;
    }

    /**
     * @param $term
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function searchQuery($term)
    {
        return self::query()
            ->where('question', 'LIKE', "%{$term}%")
            ->orWhere('answer', 'LIKE', "%{$term}%");
    }
}
