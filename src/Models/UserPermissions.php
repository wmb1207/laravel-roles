<?php

namespace Mate\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'user_permissions';

    protected $fillable = [
        'permission',
        'user_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('roles.tables_names.user_permissions', 'user_permissions');
    }

    protected static function dropDownOptions(): array
    {
        $permissionsArray = [];
        $permissions = config('roles.permissions');

        foreach ($permissions as $key => $value) {
            $permissionsArray[$value] = $value;
        }

        return $permissionsArray;
    }
}
