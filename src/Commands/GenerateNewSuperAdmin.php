<?php

namespace Fajar\Filament\Suitcms\Commands;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class GenerateNewSuperAdmin extends Command
{
    protected $description = 'Create a new admin user';

    protected $signature = 'cms:admin-generate
                            {name? : The name of the user}
                            {email? : A valid and unique email address}
                            {password? : The password for the user (min. 8 characters)}';

    public function handle(): void
    {
        $data = $this->getUserData();

        /** @var Role $superRole */
        $superRole = Role::query()->firstOrCreate(['name' => 'superadmin', 'guard_name' => 'cms']);
        $superRole->syncPermissions(Permission::all());

        /** @var Admin $super */
        $super = Admin::query()->firstOrCreate([
            'name' => $data['name'],
            'email' => $data['email'],
        ], [
            'password' => $data['password'],
        ]);
        if (!$super->hasRole($superRole)) {
            $super->syncRoles([$superRole]);
        }
        $this->info('Super Admin created with mail : ' . $super->email);
    }

    protected function getUserData(): array
    {
        return [
            'name' => $this->argument('name') ?? text(
                    label: 'Name',
                    default: 'admin',
                    required: true
                ),

            'email' => $this->argument('email') ?? text(
                    label: 'Email address',
                    default: 'admin@admin.com',
                    required: true,
                    validate: fn(string $email): ?string => match (true) {
                        !filter_var($email, FILTER_VALIDATE_EMAIL) => 'The email address must be valid.',
                        Admin::where('email', $email)->exists() => 'A user with this email address already exists',
                        default => null,
                    },
                ),

            'password' => $this->argument('password') ?? password(
                    label: 'Password',
                    required: true,
                ),
        ];
    }
}
