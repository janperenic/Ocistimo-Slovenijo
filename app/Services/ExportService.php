<?php


namespace App\Services;

use App\Models\Dump;
use App\Models\Location;
use App\Traits\ExportFileNameTrait;
use Illuminate\Support\Facades\Storage;

// TODO: not yet finished

class ExportService
{
    use ExportFileNameTrait;

    private int $updatedSince = 30;
    private string $dateSince;
    private string $disk = 'local';


    public function __construct()
    {
        $this->dateSince = now()->subDays($this->updatedSince)->toDateString();
    }

    public function update()
    {
        $disk = Storage::disk($this->disk);

        /**
         * Fetch ids of regions and municipalities that were updated in the last $this->updatedSince days
         */
        $lastUpdatedRegions = $this->lastUpdated('region');
        $lastUpdatedMunicipalities = $this->lastUpdated('municipality');

        /**
         * For each region check if file already exists and when it was created. If it doesn't exist or
         * if it was created before our $this->updatedSince, its not updated with new info and needs to be replaced
         */
        foreach ($lastUpdatedRegions as $id) {
            $path = 'regions/' . $id . '.json';
            if (!$disk->exists($path) || $disk->lastModified($path) < now()->subDays($this->updatedSince)->timestamp) {
                $this->generate($id, 'region', 'regions/');
            }
        }

        foreach ($lastUpdatedMunicipalities as $id) {
            $path = 'regions/' . $id . '.json';
            if (!$disk->exists($path) || $disk->lastModified($path) < now()->subDays($this->updatedSince)->timestamp) {
                $this->generate($id, 'municipality', 'municipalities/');
            }
        }

    }

    private function generate(int $id, string $table, string $path): void
    {
            $dumps = Location::with('dump', $table)
                ->where($table . '_id', $id)
                ->get()->pluck('dump')->toJson();
            $this->export($id, $dumps, $path);

    }

    private function export(string $name, string $json, string $path): void
    {
        Storage::disk($this->disk)->put($path . $this->name($name), $json);
    }

    private function lastUpdated(string $table): array
    {
        return Dump::with($table)
            ->where('updated_at', '>', $this->dateSince)
            ->get()
            ->pluck($table)
            ->pluck('id')
            ->unique()
            ->toArray();
    }
}
