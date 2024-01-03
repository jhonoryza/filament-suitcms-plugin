<?php

namespace Fajar\Filament\Suitcms\Resources\AdminResource\Pages;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Pages\Auth\EditProfile as AuthEditProfile;
use Illuminate\Support\Facades\Hash;

class EditProfile extends AuthEditProfile
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent()
                            ->disabled(fn (string $context): bool => $context === 'edit'),
                        $this->getCurrentPasswordFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data'),
            ),
        ];
    }

    protected function getCurrentPasswordFormComponent(): Component
    {
        return TextInput::make('current_password')
            ->password()
            ->dehydrated(false)
            ->requiredWith('password')
            ->rules([
                function () {
                    return function (string $attribute, $value, \Closure $fail) {
                        if (Hash::check($value, auth()->user()->password) === false) {
                            $fail('The :attribute is invalid.');
                        }
                    };
                },
            ]);
    }
}
