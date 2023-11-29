<?php

namespace App\Services;


use Illuminate\Support\Facades\Log;

class ReleaseService
{
    /**
     * @return array Directories name within the database/migrations directory that require migration registration
     */
    public function get(): array
    {
        $releases = [];

        try {
            $file = fopen(base_path('releases'), 'r');

            if ($file) {

                while (($line = fgets($file)) !== false) {
                    $releases[] = trim($line);
                }

                fclose($file);
            }

            return $releases;
        } catch (\Exception $e) {
            Log::info("Could not load the directories list for migration. " . $e->getMessage());
            return [];
        }
    }
}
