<?php

namespace App\Http\Controllers;


use App\Traits\ExportFileNameTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\Municipality;
use App\Models\Region;


class StaticFilesController extends Controller
{
    use ExportFileNameTrait;

    private string $base = '/app/public/';
    private string $regions = '/regions';
    private string $municipalities = '/municipalities';
    private string $lastUpdated = '2021_26_01_';

    public function municipalities(): BinaryFileResponse
    {
        return response()->download(storage_path($this->base . $this->lastUpdated . 'municipalities.json'));
    }

    public function regions(): BinaryFileResponse
    {
        return response()->download(storage_path($this->base . $this->lastUpdated .'regions.json'));
    }

    public function municipalitiesByRegions(): BinaryFileResponse
    {
        return response()->download(storage_path($this->base . $this->lastUpdated .'municipalities_by_region.json'));
    }

    public function export(Request $request): BinaryFileResponse
    {
        $regionId = $request->input('r');
        $municipalityId = $request->input('m');
        if ($regionId) {
            return $this->exportByRegion($regionId);
        }
        if ($municipalityId) {
            return $this->exportByMunicipality($municipalityId);
        }
        response()->download(storage_path($this->base . 'db_dump.json'), $this->currentDate('Seznam_divjih_odlagališč'));
    }

    // todo: finish exports

    public function exportByRegion(int $id): BinaryFileResponse
    {
        $region = Region::findOrFail($id)->name;
        return response()->download(storage_path($this->base . $this->regions . $region . '.json'), now()->toDateString() . $region . '.json');
    }

    public function exportByMunicipality(int $id): BinaryFileResponse
    {
        $municipality = Municipality::findOrFail($id)->name;
        dd($this->currentDate($municipality));
        //response()->download(storage_path($this->base . $this->municipalities . $municipality . '.json'), now()->toDateString() . '_' . $municipality . '.json');
    }
}
