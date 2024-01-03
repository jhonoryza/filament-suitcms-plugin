<?php

namespace Fajar\Filament\Suitcms\Commands;

use Fajar\Filament\Suitcms\Models\Admin;
use Fajar\Filament\Suitcms\Models\Permission;
use Fajar\Filament\Suitcms\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class GenerateNewSuperAdmin extends Command
{
    protected $description = 'Create a new admin user';

    protected $signature = 'cms:admin-generate
                            {--name= : The name of the user}
                            {--email= : A valid and unique email address}
                            {--password= : The password for the user (min. 8 characters)}';

    public function handle(): void
    {
        $data = $this->getUserData();

        Artisan::call('cms:permission-sync -n');
        $superRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'cms']);
        $superRole->syncPermissions(Permission::all());

        $super = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        $super->assignRole($superRole);
        $this->info('Super Admin Created : ' . $super->email);
    }

    protected function getUserData(): array
    {
        return [
            'name' => $this->options['name'] ?? text(
                label: 'Name',
                required: true,
            ),

            'email' => $this->options['email'] ?? text(
                label: 'Email address',
                required: true,
                validate: fn (string $email): ?string => match (true) {
                    !filter_var($email, FILTER_VALIDATE_EMAIL) => 'The email address must be valid.',
                    Admin::where('email', $email)->exists() => 'A user with this email address already exists',
                    default => null,
                },
            ),

            'password' => Hash::make($this->options['password'] ?? password(
                label: 'Password',
                required: true,
            )),
        ];
    }

}
