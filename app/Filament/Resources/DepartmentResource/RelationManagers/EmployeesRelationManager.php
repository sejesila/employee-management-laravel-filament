<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $recordTitleAttribute = 'first_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('country_id')
                    ->label('Country')
                    ->options(Country::all()->pluck('name', 'id')->toArray())
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn(callable $set) => $set('state_id', null)),
                Select::make('state_id')
                    ->label('State')
                    ->options(function (callable $get) {
                        $country = Country::find($get('country_id'));
                        if (!$country) {
                            return State::all()->pluck('name', 'id');
                        }
                        return $country->states->pluck('name', 'id');
                    })
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn(callable $set) => $set('city_id', null)),

                Select::make('city_id')
                    ->label('City')
                    ->options(function (callable $get) {
                        $state = State::find($get('state_id'));
                        if (!$state) {
                            return City::all()->pluck('name', 'id');
                        }
                        return $state->cities->pluck('name', 'id');
                    })
                    ->reactive()
                    ->required(),


                TextInput::make('first_name')->required()->maxLength(50),
                TextInput::make('last_name')->required()->maxLength(50),
                TextInput::make('address')->required()->maxLength(50),
                TextInput::make('zip_code')->required()->maxLength(5),
                DatePicker::make('birth_date')->required(),
                DatePicker::make('date_hired')->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
