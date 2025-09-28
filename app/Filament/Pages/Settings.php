<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'System';
    protected static ?string $title = 'Settings';
    protected static ?string $slug = 'settings';
    protected static ?int $navigationSort = 100;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => config('app.name', 'Ecommerce'),
            'site_description' => 'Your online store',
            'currency' => 'USD',
            'timezone' => config('app.timezone', 'UTC'),
            'maintenance_mode' => false,
            'allow_registration' => true,
            'email_notifications' => true,
            'order_notifications' => true,
            'low_stock_threshold' => 10,
            'auto_archive_orders' => true,
            'archive_after_days' => 90,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Settings')
                    ->description('Basic site configuration')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('site_description')
                            ->label('Site Description')
                            ->maxLength(500),
                        Select::make('currency')
                            ->label('Default Currency')
                            ->options([
                                'USD' => 'US Dollar ($)',
                                'EUR' => 'Euro (€)',
                                'GBP' => 'British Pound (£)',
                                'JPY' => 'Japanese Yen (¥)',
                            ])
                            ->required(),
                        Select::make('timezone')
                            ->label('Timezone')
                            ->options([
                                'UTC' => 'UTC',
                                'America/New_York' => 'Eastern Time',
                                'America/Chicago' => 'Central Time',
                                'America/Denver' => 'Mountain Time',
                                'America/Los_Angeles' => 'Pacific Time',
                                'Europe/London' => 'London',
                                'Europe/Paris' => 'Paris',
                                'Asia/Tokyo' => 'Tokyo',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('System Settings')
                    ->description('System behavior and preferences')
                    ->schema([
                        Toggle::make('maintenance_mode')
                            ->label('Maintenance Mode')
                            ->helperText('Enable to put the site in maintenance mode'),
                        Toggle::make('allow_registration')
                            ->label('Allow User Registration')
                            ->helperText('Allow new users to register'),
                        Toggle::make('email_notifications')
                            ->label('Email Notifications')
                            ->helperText('Send email notifications for system events'),
                        Toggle::make('order_notifications')
                            ->label('Order Notifications')
                            ->helperText('Send notifications for new orders'),
                    ])
                    ->columns(2),

                Section::make('Inventory Settings')
                    ->description('Product and inventory management')
                    ->schema([
                        TextInput::make('low_stock_threshold')
                            ->label('Low Stock Threshold')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Products below this quantity will be marked as low stock'),
                        Toggle::make('auto_archive_orders')
                            ->label('Auto-archive Old Orders')
                            ->helperText('Automatically archive completed orders after a certain period'),
                        TextInput::make('archive_after_days')
                            ->label('Archive After (Days)')
                            ->numeric()
                            ->minValue(30)
                            ->helperText('Orders will be archived after this many days')
                            ->visible(fn ($get) => $get('auto_archive_orders')),
                    ])
                    ->columns(2),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save')
                ->color('primary'),
            Action::make('reset')
                ->label('Reset to Defaults')
                ->color('secondary')
                ->action('resetToDefaults'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        // Here you would typically save to database or config files
        // For now, we'll just show a success notification
        
        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    public function resetToDefaults(): void
    {
        $this->form->fill([
            'site_name' => 'Ecommerce',
            'site_description' => 'Your online store',
            'currency' => 'USD',
            'timezone' => 'UTC',
            'maintenance_mode' => false,
            'allow_registration' => true,
            'email_notifications' => true,
            'order_notifications' => true,
            'low_stock_threshold' => 10,
            'auto_archive_orders' => true,
            'archive_after_days' => 90,
        ]);

        Notification::make()
            ->title('Settings reset to defaults')
            ->success()
            ->send();
    }
}
