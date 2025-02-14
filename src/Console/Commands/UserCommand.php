<?php

namespace Mate\Roles\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Mate\Roles\Models\Role;


class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mate:user-role {userid} {--roles=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure a User with one or many permissions or even a complete role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roles = explode(',' , $this->option('roles'));
        $dbRoles = Role::where('name', 'in', '$roles')->all();
        $id = intval($this->argument('userid'));
        $user = User::findOrFail($id);
        $this->info("Updating user: {$user->id}");
        $user->roles()->sync(array_map(fn($role) => $role->id, $dbRoles));
    }
}
