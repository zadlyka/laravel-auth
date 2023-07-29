<?php

namespace App\Models;

use App\Helpers\FilterHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'permission'
    ];

    protected $hidden = [
        'deleted_at',
        'pivot'
    ];

    protected $casts = [
        'permission' => 'array',
    ];

    public function scopeSearch(Builder $query, $search): void
    {
        $query->when($search ?? false, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeSort(Builder $query, $sortBy): void
    {
        $query->when($sortBy ?? false, function ($query, $sort) {
            $sortby = explode(":", $sort);
            $field = $sortby[0];
            $order = $sortby[1];

            return $query->orderBy($field, $order);
        });
    }

    public function scopeFilter(Builder $query, $filter): void
    {
        $query->when($filter['created_at'] ?? false, function ($query, $value) {
            return FilterHelper::querying($query, 'created_at', $value);
        });

        $query->when($filter['updated_at'] ?? false, function ($query, $value) {
            return FilterHelper::querying($query, 'updated_at', $value);
        });
    }
}
