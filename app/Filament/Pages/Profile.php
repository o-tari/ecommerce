<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Account';
    protected static ?string $title = 'Profile';
    protected static ?string $slug = 'profile';
    protected static ?int $navigationSort = 200;

    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();
        
        $this->form->fill([
            'name' => $user->name ?? '',
            'email' => $user->email ?? '',
            'avatar' => $user->avatar ?? null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->description('Update your personal details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('avatar')
                            ->label('Profile Picture')
                            ->image()
                            ->imageEditor()
                            ->circleCropper()
                            ->directory('avatars')
                            ->maxSize(5120), // 5MB
                    ])
                    ->columns(2),

                Section::make('Change Password')
                    ->description('Update your password')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->dehydrated(false)
                            ->rules(['required_with:new_password']),
                        TextInput::make('new_password')
                            ->label('New Password')
                            ->password()
                            ->rules(['confirmed', Password::defaults()])
                            ->dehydrated(false),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->submit('save')
                ->color('primary'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();

        // Update basic information
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Update avatar if provided
        if (isset($data['avatar'])) {
            $user->update(['avatar' => $data['avatar']]);
        }

        // Update password if provided
        if (!empty($data['new_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->title('Current password is incorrect')
                    ->danger()
                    ->send();
                return;
            }

            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);
        }

        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();

        // Clear password fields
        $this->form->fill([
            'current_password' => '',
            'new_password' => '',
            'new_password_confirmation' => '',
        ]);
    }
}
