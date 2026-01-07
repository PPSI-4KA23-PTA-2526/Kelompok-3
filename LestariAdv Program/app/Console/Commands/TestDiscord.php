<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestDiscord extends Command
{
    protected $signature = 'test:discord';
    protected $description = 'Test Discord webhook';

    public function handle()
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        if (!$webhookUrl) {
            $this->error('DISCORD_WEBHOOK_URL tidak ditemukan di .env');
            return;
        }

        $this->info('Mengirim test message ke Discord...');

        try {
            $response = Http::post($webhookUrl, [
                'content' => 'Test dari Laravel Artisan Command! 🎯'
            ]);

            if ($response->successful()) {
                $this->info('✅ Berhasil kirim ke Discord!');
            } else {
                $this->error('❌ Gagal: ' . $response->status() . ' - ' . $response->body());
            }

        } catch (\Exception $e) {
            $this->error('Exception: ' . $e->getMessage());
        }
    }
}
