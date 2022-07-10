<?php

namespace App\Models;

use App\ToDoListAttachment;
use App\User;
use App\UserSite;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ToDoList
 *
 * status 0 - pending
 * status 1 - being-done
 * status 2 - done
 *
 * @package App\Models
 */
class ToDoList extends Model
{
    const STATUS = [
        0 => 'pending',
        1 => 'being-done',
        2 => 'done',
    ];

    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    protected $fillable = ['user_id', 'employee_id', 'site_id', 'status', 'title', 'description', 'due_date'];

    public function getStatus()
    {
        return self::STATUS[$this->status ?: 0];
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'employee_id');
    }

    public function site()
    {
        return $this->hasOne(UserSite::class, 'id', 'site_id');
    }

    public function attachments()
    {
        return $this->hasMany(ToDoListAttachment::class);
    }

    public function filterDate(&$query, $daterange)
    {
        try {
            if ($daterange && strpos($daterange, ' - ') !== false) {
                list($dateStart, $dateEnd) = explode(' - ', $daterange);

                $dateStart = str_replace('/', '-', $dateStart);

                $dateEnd = str_replace('/', '-', $dateEnd);

                $query->whereBetween('due_date', [Carbon::parse($dateStart), Carbon::parse($dateEnd)]);
            }
        } catch(\Exception $e) {
            // dd($e);
        }
    }

    public function filterUserEmployees(&$query)
    {
        $query->with('employee');
        $query->whereRaw('employee_id != user_id and user_id = ' . auth()->id());
    }

    public function filterUserEmployer(&$query, $userId = null)
    {
        $query->where(['user_id' => $userId ?: auth()->id(), 'employee_id' => auth()->id()]);
    }

    public function filterByEmployeeId(&$query, $employee_id)
    {
        if ($employee_id) {
            $query->where('employee_id', $employee_id);
        }
    }

    public function filterByEmployeeSiteId(&$query, $site_id)
    {
        if (intval($site_id)) {
            $query->where('site_id', $site_id);
        }
    }

    public function filterByStatus(&$query, $status)
    {
        if (is_numeric($status) && in_array($status, [0, 1, 2])) {
            $query->where('status', $status);
        }
    }

    public function sortDescByEmployeeId(&$query)
    {
        $query->orderByDesc('employee_id');
    }

    public function sortDescByEmployerId(&$query)
    {
        $query->orderByDesc('user_id');
    }

    public static function searchEmployers($request, &$incompleteCount = 0, $userId = null)
    {
        $model = new self();

        $query = $model->query()->with(['attachments' => function ($query) {
            $query->with('user');
        }]);

        $model->filterUserEmployer($query, $userId);

        $model->sortDescByEmployerId($query);

        $model->filterByStatus($query, $request->status);

        $model->filterDate($query, $request->daterange);

        $result = $query->get();

        $incompleteCount = $query->whereIn('status', [0, 1])->count();

        return $result;
    }

    public static function searchEmployees($request, &$incompleteCount = 0)
    {
        $model = new self();

        $query = $model->query()->with(['attachments' => function ($query) {
            $query->with('user');
        }]);

        $model->filterUserEmployees($query);

        $model->filterByEmployeeId($query, $request->employee_id);

        $model->filterByEmployeeSiteId($query, $request->site_id);

        $model->sortDescByEmployeeId($query);

        $model->filterByStatus($query, $request->status);

        $model->filterDate($query, $request->daterange);

        $result = $query->get();

        $incompleteCount = $query->whereIn('status', [0, 1])->count();

        return $result;
    }
}
