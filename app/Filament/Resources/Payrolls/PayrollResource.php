<?php

namespace App\Filament\Resources\Payrolls;

use App\Filament\Resources\Payrolls\Pages\ManagePayrolls;
use App\Models\Payroll;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationLabel = 'Penggajian';

    protected static ?string $label = 'Penggajian';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section::make('Periode Payroll')
                //     ->columns(2)
                //     ->components([
                TextInput::make('year')
                    ->required()
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(now()),

                Select::make('month')
                    ->required()
                    ->options([
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ]),
                // ]),
                // Section::make('Tanggal Periode')
                //     ->columns(2)
                //     ->components([
                DatePicker::make('period_start')
                    ->required(),

                DatePicker::make('period_end')
                    ->required()
                    ->afterOrEqual('period_start'),
                // ]),

                // Section::make('Status')
                //     ->columns(2)
                //     ->components([
                Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'processed' => 'Processed',
                        'approved' => 'Approved',
                        'paid' => 'Paid',
                    ])
                    ->default('draft')
                    ->disabled(fn($record) => $record?->status === 'paid'),

                DateTimePicker::make('processed_at')
                    ->disabled(),
                // ]),

                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('year')
                    ->numeric(),
                TextEntry::make('month')
                    ->numeric(),
                TextEntry::make('period_start')
                    ->date(),
                TextEntry::make('period_end')
                    ->date(),
                TextEntry::make('status'),
                TextEntry::make('processed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('processed_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')->sortable(),
                TextColumn::make('month')
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::create()->month($state)->translatedFormat('F'))
                    ->sortable(),

                TextColumn::make('period_start')->date(),
                TextColumn::make('period_end')->date(),

                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'warning' => 'processed',
                        'info' => 'approved',
                        'success' => 'paid',
                    ]),

                TextColumn::make('processed_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn($record) => $record->status === 'draft'),
                DeleteAction::make()
                    ->visible(fn($record) => $record->status === 'draft'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePayrolls::route('/'),
        ];
    }
}
