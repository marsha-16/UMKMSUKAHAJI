<?php

namespace App\Extensions;

use Illuminate\Session\DatabaseSessionHandler as BaseHandler;
use Illuminate\Support\Facades\Log;

class SafeDatabaseSessionHandler extends BaseHandler
{
    public function write($sessionId, $data)
    {
        try {
            // Cek data di DB
            $current = $this->getQuery()->find($sessionId);

            // Jika payload sama → update hanya last_activity
            if ($current && $current->payload === $data) {
                return $this->getQuery()->where('id', $sessionId)->update([
                    'last_activity' => time(),
                ]);
            }

            // Payload beda → update penuh
            return parent::write($sessionId, $data);
        } catch (\Throwable $e) {
            // Kalau MySQL error, simpan session di file sementara
            Log::error('Database session write failed, fallback to file: ' . $e->getMessage());

            file_put_contents(
                storage_path("framework/sessions/fallback_$sessionId"),
                $data
            );

            return true; // biar login tetap jalan
        }
    }
}
