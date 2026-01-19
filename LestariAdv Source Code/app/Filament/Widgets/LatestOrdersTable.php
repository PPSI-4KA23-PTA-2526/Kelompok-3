<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Forms;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;

class LatestOrdersTable extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Pesanan Terbaru (Sudah Dibayar)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('payment_status', 'paid')
                    ->latest()
                    ->limit(15)
            )
            ->columns([
                Tables\Columns\TextColumn::make('kode_order')
                    ->label('Kode Order')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->icon('heroicon-m-ticket'),

                Tables\Columns\TextColumn::make('nama_pemesan')
                    ->label('Pemesan')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('nama_produk')
                    ->label('Produk')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (Order $record): string {
                        return $record->nama_produk . ($record->nama_variasi ? ' - ' . $record->nama_variasi : '');
                    }),

                Tables\Columns\TextColumn::make('qty')
                    ->label('Qty')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

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

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'credit_card' => 'Kartu Kredit',
                        'bank_transfer' => 'Transfer Bank',
                        'e-wallet' => 'E-Wallet',
                        'cod' => 'COD',
                        default => $state ?? '-',
                    })
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status Pesanan')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'diproses' => 'Diproses',
                        'sedang_dikerjakan' => 'Sedang Dikerjakan',
                        'siap_kirim' => 'Siap Kirim',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'menunggu_pembayaran',
                        'info' => 'diproses',
                        'primary' => 'sedang_dikerjakan',
                        'success' => fn($state) => in_array($state, ['siap_kirim', 'dikirim', 'selesai']),
                        'danger' => 'dibatalkan',
                    ]),

                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->description(
                        fn(Order $record): string =>
                        $record->paid_at ? $record->paid_at->format('d M Y H:i') : '-'
                    )
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Order')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->description(fn(Order $record): string => $record->created_at->format('d M Y H:i'))
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->bulkActions([
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

                Tables\Actions\BulkAction::make('exportSelected')
                    ->label('Export Data')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($records) {
                        // Export ke CSV
                        $filename = 'pesanan_' . now()->format('Y-m-d_His') . '.csv';
                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"$filename\"",
                        ];

                        $callback = function () use ($records) {
                            $file = fopen('php://output', 'w');

                            // Header CSV
                            fputcsv($file, [
                                'Kode Order',
                                'Nama Pemesan',
                                'No HP',
                                'Email',
                                'Produk',
                                'Qty',
                                'Total',
                                'Status',
                                'Metode Pembayaran',
                                'Tanggal Order',
                                'Tanggal Bayar',
                            ]);

                            // Data
                            foreach ($records as $record) {
                                fputcsv($file, [
                                    $record->kode_order,
                                    $record->nama_pemesan,
                                    $record->no_hp,
                                    $record->email,
                                    $record->nama_produk,
                                    $record->qty,
                                    $record->total,
                                    $record->status,
                                    $record->payment_method ?? '-',
                                    $record->created_at->format('Y-m-d H:i:s'),
                                    $record->paid_at ? $record->paid_at->format('Y-m-d H:i:s') : '-',
                                ]);
                            }

                            fclose($file);
                        };

                        return response()->stream($callback, 200, $headers);
                    })
                    ->deselectRecordsAfterCompletion(),
            ])
            ->emptyStateHeading('Belum ada pesanan yang dibayar')
            ->emptyStateDescription('Pesanan yang sudah dibayar akan muncul di sini')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }
}
