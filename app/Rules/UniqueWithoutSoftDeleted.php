<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UniqueWithoutSoftDeleted implements Rule
{
    private $table;
    private $column;
    private $ignoreId;

    public function __construct($table, $column, $ignoreId = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->whereNull('deleted_at');

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        return $query->doesntExist();
    }

    public function message()
    {
        return __('validation.unique');
    }
}
