<?php

namespace Mate\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('roles.tables_names.role_user', 'xxx');
    }
}
