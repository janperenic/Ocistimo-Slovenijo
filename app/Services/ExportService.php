<?php


namespace App\Services;

use App\Models\Dump;
use App\Models\Location;
use App\Models\Municipality;
use App\Models\Region;
use App\Traits\ExportFileNameTrait;
use Illuminate\Support\Facades\Storage;

// TODO: not yet finished

class ExportService
{
    use ExportFileNameTrait;

    private int $updatedSince = 30;

    private string $regionPath;
    private string $municipalityPath;
    private string $dateSince;


    public function __construct()
    {
        $this->regionPath = storage_path('app/public/regions/');
        $this->municipalityPath = storage_path('app/public/municipalities/');
        $this->dateSince = now()->subDays($this->updatedSince)->toDateString();
    }

    public function update()
    {
        $lastUpdatedRegions = $this->lastUpdatedRegions();
        $lastUpdatedMunicipalities = $this->lastUpdatedMunicipalities();

        foreach ($lastUpdatedRegions as $region) {
            $name = Region::find($region)->name;
            $dumps = Location::with('dump')
                ->where('region_id', $region)
                ->get()->map(fn($e) => $e->dump)->toJson();
            $this->export($name, $dumps);
        }

        foreach ($lastUpdatedMunicipalities as $municipality) {
            $name = Municipality::find($municipality)->name;
            $dumps = Location::with('dump')
                ->where('municipality_id', $municipality)
                ->get()->map(fn($e) => $e->dump)->toJson();
            $this->export($name, $dumps);
        }
    }

    public function export(string $name, string $json): void
    {
        Storage::disk('local')->put($this->name($name), $json);
    }

    private function lastUpdatedRegions(): array
    {
        return Dump::where('updated_at', '>', $this->dateSince)
            ->get()->map(function ($e) {
                return $e->region->id;
            })->unique()->toArray();
    }

    private function lastUpdatedMunicipalities(): array
    {
        return Dump::where('updated_at', '>', $this->dateSince)
            ->get()->map(function ($e) {
                return $e->municipality->id;
            })->unique()->toArray();
    }
}
