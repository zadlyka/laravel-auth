<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Helpers\FilterHelper;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public $with = ['roles'];

    public function scopeSearch(Builder $query, $search): void
    {
        $query->when($search ?? false, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
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
