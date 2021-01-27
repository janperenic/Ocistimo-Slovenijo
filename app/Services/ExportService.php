<?php


namespace App\Services;

use App\Models\Dump;
use App\Models\Location;
use App\Models\Region;
use App\Traits\ExportFileNameTrait;
use Illuminate\Support\Collection;

// TODO: not yet finished

class ExportService
{
    use ExportFileNameTrait;

    private int $updatedSince = 50;
    private string $base = 'app/public';
    private array $references = ['volume', 'access', 'irsop', 'terrain'];
    private array $models = ['trashType', 'estimatedTrashVolume', 'coordinate', 'comments', 'location'];

    private string $regionPath;
    private string $municipalityPath;
    private array $all;
    private string $dateSince;


    public function __construct()
    {
        $this->regionPath = storage_path('app/public/regions/');
        $this->municipalityPath = storage_path('app/public/municipalities/');
        $this->all = [...$this->references, ...$this->models];
        $this->dateSince = now()->subDay($this->updatedSince)->toDateString();
    }

    public function exportRegions()
    {
        $lastUpdatedRegions = $this->lastUpdated();
        dd($lastUpdatedRegions);
    }

    private function lastUpdated(int $regionId = 0, $municipalityId = 0)
    {
        $dump = Dump::with(...$this->all)->where('updated_at', '>', $this->dateSince);
        if($regionId) {
            $dump->whereHas('region', function($query) use($regionId) {
                $query->where('id', $regionId)->select('name')->get();
            });
        }
        if($municipalityId) {
            $dump->whereHas('municipality', function($query) use($municipalityId) {
                $query->where('id', $municipalityId);
            });
        }
        $dump = $dump->get();
        return $dump->toArray();
    }

    private function lastUpdatedMunicipalities(): Collection
    {
        return Location::with('dump', 'municipality')
            ->whereHas('dump', function ($query) {
                $query->where('updated_at', '>', now()->subDays($this->updatedSince)->toDateString());
            })->get()->pluck('municipality')->pluck('id')->unique();
    }

    private function regionData(int $id)
    {

    }
}
