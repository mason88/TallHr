<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Personal Info')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(30),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(30),
                        Forms\Components\DatePicker::make('dob')
                            ->label('Date of birth')
                            ->required()
                            ->maxDate(now()),
                        Forms\Components\TextInput::make('ssn')
                            ->label('SSN')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('street')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(30),
                        Forms\Components\Select::make('state_id')
                            ->relationship('state', 'name'),
                        Forms\Components\TextInput::make('zip')
                            ->label('Zip code')
                            ->maxLength(20),
                    ]),
                Forms\Components\Fieldset::make('Work Info')
                    ->disabled(auth()->user()->role != 'HR')
                    ->schema([
                        Forms\Components\TextInput::make('work_email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('work_phone')
                            ->tel()
                            ->maxLength(20),                    
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date'),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(30),
                        Forms\Components\Select::make('dept_id')
                            ->label('Department')
                            ->relationship('dept', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('manager_id')
                            ->label('Manager')
                            ->relationship('manager', 'full_name')
                            ->searchable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dept.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('dept.name')
                    ->relationship('dept', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
