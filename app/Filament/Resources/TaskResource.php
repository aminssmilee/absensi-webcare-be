<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Manajemen Tugas';
    protected static ?string $navigationLabel = 'Tugas';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Tugas')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('assigned_to')
                    ->label('Diberikan ke')
                    ->relationship('assignee', 'name')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Toggle::make('is_done')
                    ->label('Selesai?'),

                Forms\Components\Textarea::make('comment')
                    ->label('Komentar User')
                    ->disabled(), // hanya bisa diisi user lewat API/FE
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('assignee.name')
                    ->label('User')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_done')
                    ->boolean()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Komentar User'),

                // Tables\Columns\TextColumn::make('creator.name')
                //     ->label('Dibuat oleh'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Dibuat'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
