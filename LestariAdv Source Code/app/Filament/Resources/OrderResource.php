<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\Widgets\OrderStatsWidget;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Pesanan';

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        // Forms\Components\Select::make('product_id')
                        //     ->label('Produk')
                        //     ->relationship('product', 'nama')
                        //     ->required()
                        //     ->searchable(),

                        // Forms\Components\Select::make('product_variant_id')
                        //     ->label('Variasi')
                        //     ->relationship('variant', 'nama')
                        //     ->searchable(),

                        Forms\Components\TextInput::make('nama_produk')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('nama_variasi')
                            ->label('Nama Variasi')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('qty')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),

                        Forms\Components\TextInput::make('harga')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),

                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\KeyValue::make('price_option')
                            ->label('Opsi Harga')
                            ->keyLabel('Opsi')
                            ->valueLabel('Nilai'),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Customer')
                    ->schema([
                        Forms\Components\TextInput::make('nama_pemesan')
                            ->label('Nama Pemesan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('no_hp')
                            ->label('No. HP')
                            ->required()
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('catatan_customer')
                            ->label('Catatan Customer')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('file_desain')
                            ->label('File Desain')
                            ->disk('public')
                            ->directory('designs')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('kode_order')
                            ->label('Kode Order')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        // Forms\Components\TextInput::make('midtrans_order_id')
                        //     ->label('Midtrans Order ID')
                        //     ->maxLength(255),

                        // Forms\Components\TextInput::make('snap_token')
                        //     ->label('Snap Token')
                        //     ->maxLength(255),

                        Forms\Components\Select::make('payment_method')
                            ->label('Metode Pembayaran')
                            ->options([
                                'credit_card' => 'Kartu Kredit',
                                'bank_transfer' => 'Transfer Bank',
                                'e-wallet' => 'E-Wallet',
                                'cod' => 'COD',
                            ]),

                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Lunas',
                                'failed' => 'Gagal',
                                'expired' => 'Kedaluwarsa',
                            ])
                            ->required()
                            ->default('pending'),

                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Dibayar Pada'),
                    ])->columns(2),

                Forms\Components\Section::make('Status Pesanan')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                'diproses' => 'Diproses',
                                'sedang_dikerjakan' => 'Sedang Dikerjakan',
                                'siap_kirim' => 'Siap Kirim',
                                'dikirim' => 'Dikirim',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->required()
                            ->default('menunggu_pembayaran'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_order')
                    ->label('Kode Order')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nama_pemesan')
                    ->label('Pemesan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Produk')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('qty')
                    ->label('Qty')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\IconColumn::make('file_desain')
                    ->label('File Desain')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-arrow-down')
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->tooltip(
                        fn(Order $record): string =>
                        $record->file_desain ? 'Ada file desain' : 'Tidak ada file'
                    ),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'failed',
                        'success' => 'paid',
                        'secondary' => 'expired',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-x-circle' => 'failed',
                        'heroicon-o-check-circle' => 'paid',
                        'heroicon-o-exclamation-circle' => 'expired',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'menunggu_pembayaran',
                        'info' => 'diproses',
                        'primary' => 'sedang_dikerjakan',
                        'success' => fn($state) => in_array($state, ['siap_kirim', 'dikirim', 'selesai']),
                        'danger' => 'dibatalkan',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Lunas',
                        'failed' => 'Gagal',
                        'expired' => 'Kedaluwarsa',
                    ]),

                SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'diproses' => 'Diproses',
                        'sedang_dikerjakan' => 'Sedang Dikerjakan',
                        'siap_kirim' => 'Siap Kirim',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ]),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('updateStatus')
                    ->label('Update Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'diproses' => 'Diproses',
                                'sedang_dikerjakan' => 'Sedang Dikerjakan',
                                'siap_kirim' => 'Siap Kirim',
                                'dikirim' => 'Dikirim',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->required()
                            ->native(false)
                            ->default(fn(Order $record) => $record->status),

                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin (Opsional)')
                            ->rows(3)
                            ->placeholder('Tambahkan catatan untuk perubahan status ini...'),

                        Forms\Components\Checkbox::make('kirim_email')
                            ->label('Kirim email notifikasi ke customer')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $oldStatus = $record->status;

                        $record->update([
                            'status' => $data['status']
                        ]);

                        // Kirim email jika checkbox dicentang dan email tersedia
                        if (!empty($data['kirim_email']) && $record->email) {
                            try {
                                Mail::to($record->email)->send(
                                    new OrderStatusUpdated(
                                        $record->fresh(),
                                        $oldStatus,
                                        $data['catatan_admin'] ?? null
                                    )
                                );

                                Log::info('STATUS UPDATE EMAIL SENT', [
                                    'order_id' => $record->id,
                                    'kode_order' => $record->kode_order,
                                    'email' => $record->email,
                                    'old_status' => $oldStatus,
                                    'new_status' => $data['status']
                                ]);
                            } catch (\Exception $e) {
                                Log::error('STATUS UPDATE EMAIL FAILED', [
                                    'order_id' => $record->id,
                                    'kode_order' => $record->kode_order,
                                    'email' => $record->email,
                                    'error' => $e->getMessage()
                                ]);

                                // Optional: Tampilkan notifikasi error ke admin
                                \Filament\Notifications\Notification::make()
                                    ->title('Email gagal dikirim')
                                    ->body('Status berhasil diupdate, tapi email gagal dikirim.')
                                    ->warning()
                                    ->send();
                            }
                        }
                    })
                    ->successNotificationTitle('Status pesanan berhasil diupdate')
                    ->modalWidth('md'),

                Tables\Actions\Action::make('downloadDesign')
                    ->label('Download File')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->visible(fn(Order $record): bool => !empty($record->file_desain))
                    ->action(function (Order $record) {
                        if (!$record->file_desain) {
                            return;
                        }

                        // Jika file disimpan di storage
                        if (Storage::disk('public')->exists($record->file_desain)) {
                            return response()->download(
                                Storage::disk('public')->path($record->file_desain),
                                'desain_' . $record->kode_order . '.' . pathinfo($record->file_desain, PATHINFO_EXTENSION)
                            );
                        }
                    })
                    ->tooltip('Download file desain customer'),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-arrow-path')
                        ->color('primary')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Status Pesanan')
                                ->options([
                                    'diproses' => 'Diproses',
                                    'sedang_dikerjakan' => 'Sedang Dikerjakan',
                                    'siap_kirim' => 'Siap Kirim',
                                    'dikirim' => 'Dikirim',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan',
                                ])
                                ->required()
                                ->native(false),

                            Forms\Components\Textarea::make('catatan_admin')
                                ->label('Catatan Admin (Opsional)')
                                ->rows(3)
                                ->placeholder('Tambahkan catatan untuk perubahan status ini...'),

                            Forms\Components\Checkbox::make('kirim_email')
                                ->label('Kirim email notifikasi ke customer')
                                ->default(true)
                                ->helperText('Email akan dikirim ke semua pesanan yang dipilih')
                                ->inline(false),
                        ])
                        ->action(function ($records, array $data): void {
                            $successCount = 0;
                            $failCount = 0;

                            foreach ($records as $record) {
                                $oldStatus = $record->status;

                                $record->update(['status' => $data['status']]);

                                // Kirim email jika checkbox dicentang dan email tersedia
                                if (!empty($data['kirim_email']) && $record->email) {
                                    try {
                                        Mail::to($record->email)->send(
                                            new OrderStatusUpdated(
                                                $record->fresh(),
                                                $oldStatus,
                                                $data['catatan_admin'] ?? null
                                            )
                                        );
                                        $successCount++;
                                    } catch (\Exception $e) {
                                        $failCount++;
                                        Log::error('BULK STATUS UPDATE EMAIL FAILED', [
                                            'order_id' => $record->id,
                                            'kode_order' => $record->kode_order,
                                            'error' => $e->getMessage()
                                        ]);
                                    }
                                }
                            }

                            // Notifikasi hasil
                            if ($failCount > 0) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Sebagian email gagal dikirim')
                                    ->body("Berhasil: {$successCount}, Gagal: {$failCount}")
                                    ->warning()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('Status pesanan berhasil diupdate'),

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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            OrderStatsWidget::class,
        ];
    }
}
