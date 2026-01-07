<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Produk';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Produk';

    protected static ?string $pluralModelLabel = 'Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->description('Informasi dasar produk')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'nama_kategori')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nama_kategori')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn($state, Forms\Set $set) =>
                                        $set('slug', Str::slug($state))
                                    ),
                                Forms\Components\TextInput::make('slug')->required(),
                                Forms\Components\Textarea::make('deskripsi')->rows(2),
                                Forms\Components\Toggle::make('is_active')->default(true),
                            ]),

                        Forms\Components\TextInput::make('nama_produk')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(string $operation, $state, Forms\Set $set) =>
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\MarkdownEditor::make('deskripsi')
                            ->label('Deskripsi Produk')
                            ->columnSpanFull()
                            ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList']),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan Tambahan')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->collapsible(),

                Forms\Components\Section::make('Variasi & Harga')
                    ->description('Kelola variasi produk beserta harga per ukuran - Langsung isi semuanya!')
                    ->schema([
                        Forms\Components\Repeater::make('variants')
                            ->relationship('variants')
                            ->label('Variasi Produk')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('nama_variasi')
                                            ->label('Nama Variasi')
                                            ->required()
                                            ->placeholder('Contoh: Warna Merah, Bahan Premium')
                                            ->columnSpan(2),

                                        Forms\Components\TextInput::make('urutan')
                                            ->label('Urutan')
                                            ->numeric()
                                            ->default(0)
                                            ->columnSpan(1),

                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Aktif')
                                            ->default(true)
                                            ->inline(false)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(4),

                                Forms\Components\FileUpload::make('images')
                                    ->label('Gambar Variasi')
                                    ->image()
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->reorderable()
                                    ->imageEditor()
                                    ->directory('variants')
                                    ->columnSpanFull()
                                    ->helperText('Upload gambar untuk variasi ini (max 5)'),

                                Forms\Components\Repeater::make('price_data')
                                    ->label('Daftar Harga per Ukuran')
                                    ->schema([
                                        Forms\Components\TextInput::make('size')
                                            ->label('Ukuran')
                                            ->required()
                                            ->placeholder('S, M, L, XL, 20x30cm')
                                            ->maxLength(50),

                                        Forms\Components\TextInput::make('harga')
                                            ->label('Harga')
                                            ->required()
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->minValue(0)
                                            ->step(1000),

                                        Forms\Components\TextInput::make('harga_coret')
                                            ->label('Harga Coret')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->minValue(0)
                                            ->step(1000)
                                            ->helperText('Opsional'),

                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Aktif')
                                            ->default(true)
                                            ->inline(false),
                                    ])
                                    ->columns(4)
                                    ->defaultItems(1)
                                    ->addActionLabel('Tambah Ukuran & Harga')
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->collapsed()
                                    ->itemLabel(
                                        fn(array $state): ?string => ($state['size'] ?? 'Ukuran') . ' - Rp ' . number_format($state['harga'] ?? 0, 0, ',', '.')
                                    )
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull()
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Variasi Baru')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->collapsed()
                            ->cloneable()
                            ->itemLabel(fn(array $state): ?string => $state['nama_variasi'] ?? 'Variasi Baru'),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Pengaturan')
                    ->description('Pengaturan umum produk')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('estimasi_unit')
                                    ->label('Satuan Estimasi')
                                    ->options([
                                        'jam' => 'Jam',
                                        'hari' => 'Hari',
                                    ])
                                    ->default('jam')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $value = $get('estimasi_value');
                                        if ($value) {
                                            if ($state === 'hari') {
                                                $set('estimasi_pengerjaan_jam', $value * 24);
                                            } else {
                                                $set('estimasi_pengerjaan_jam', $value);
                                            }
                                        }
                                    })
                                    ->dehydrated(false), // Tidak disimpan ke database

                                Forms\Components\TextInput::make('estimasi_value')
                                    ->label('Estimasi Pengerjaan')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(1)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        $unit = $get('estimasi_unit') ?? 'jam';
                                        if ($unit === 'hari') {
                                            $set('estimasi_pengerjaan_jam', $state * 24);
                                        } else {
                                            $set('estimasi_pengerjaan_jam', $state);
                                        }
                                    })
                                    ->suffix(fn(Forms\Get $get) => $get('estimasi_unit') === 'hari' ? 'Hari' : 'Jam')
                                    ->helperText(function (Forms\Get $get) {
                                        $value = $get('estimasi_value');
                                        $unit = $get('estimasi_unit') ?? 'jam';

                                        if (!$value) return null;

                                        if ($unit === 'hari') {
                                            $totalJam = $value * 24;
                                            return "= {$totalJam} Jam";
                                        } else {
                                            if ($value >= 24) {
                                                $hari = floor($value / 24);
                                                $sisaJam = $value % 24;
                                                if ($sisaJam > 0) {
                                                    return "= {$hari} Hari {$sisaJam} Jam";
                                                }
                                                return "= {$hari} Hari";
                                            }
                                            return null;
                                        }
                                    })
                                    ->dehydrated(false), // Tidak disimpan ke database

                                Forms\Components\Hidden::make('estimasi_pengerjaan_jam')
                                    ->default(0), // Field yang sebenarnya disimpan
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('first_variant_image')
                    ->label('Gambar')
                    ->circular()
                    ->state(function (Product $record) {
                        $firstVariant = $record->variants->first();
                        if ($firstVariant && !empty($firstVariant->images)) {
                            return is_array($firstVariant->images) ? $firstVariant->images[0] : $firstVariant->images;
                        }
                        return null;
                    })
                    ->defaultImageUrl(url('/images/no-image.png')),

                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn($record) => $record->category?->nama_kategori),

                Tables\Columns\TextColumn::make('price_range')
                    ->label('Harga')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('variants_count')
                    ->label('Variasi')
                    ->state(fn($record) => $record->variants()->count())
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('total_price_options')
                    ->label('Total Harga')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('estimasi_formatted')
                    ->label('Estimasi')
                    ->sortable(query: function ($query, string $direction) {
                        return $query->orderBy('estimasi_pengerjaan_jam', $direction);
                    })
                    ->badge()
                    ->color('warning')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable()
                    ->badge()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'nama_kategori')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua Produk')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Non-aktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_active' => false])),
                ]),
            ])
            ->defaultSort('urutan', 'asc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Produk')
                    ->schema([
                        Infolists\Components\TextEntry::make('category.nama_kategori')
                            ->label('Kategori')
                            ->badge()
                            ->color('primary'),

                        Infolists\Components\TextEntry::make('nama_produk')
                            ->label('Nama Produk')
                            ->weight(FontWeight::Bold)
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\TextEntry::make('slug')
                            ->badge()
                            ->color('info')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('price_range')
                            ->label('Range Harga')
                            ->badge()
                            ->color('success')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large),

                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean(),

                        Infolists\Components\TextEntry::make('estimasi_formatted')
                            ->label('Estimasi Pengerjaan')
                            ->badge()
                            ->color('warning'),

                        Infolists\Components\TextEntry::make('deskripsi')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Variasi & Harga')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('variants')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('nama_variasi')
                                    ->weight(FontWeight::Bold)
                                    ->size(Infolists\Components\TextEntry\TextEntrySize::Medium),

                                Infolists\Components\IconEntry::make('is_active')
                                    ->label('Status')
                                    ->boolean(),

                                Infolists\Components\ImageEntry::make('images')
                                    ->label('Gambar')
                                    ->columnSpanFull()
                                    ->height(120),

                                Infolists\Components\RepeatableEntry::make('price_data')
                                    ->label('Daftar Harga')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('size')
                                            ->label('Ukuran')
                                            ->badge()
                                            ->color('warning'),

                                        Infolists\Components\TextEntry::make('harga')
                                            ->label('Harga')
                                            ->money('IDR')
                                            ->badge()
                                            ->color('success'),

                                        Infolists\Components\TextEntry::make('harga_coret')
                                            ->label('Harga Coret')
                                            ->money('IDR')
                                            ->badge()
                                            ->color('gray')
                                            ->placeholder('-'),

                                        Infolists\Components\IconEntry::make('is_active')
                                            ->label('Aktif')
                                            ->boolean(),
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();
        return $count > 10 ? 'success' : ($count > 0 ? 'warning' : 'danger');
    }
}
