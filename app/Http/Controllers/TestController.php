<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Services\ExportService;

class TestController extends Controller
{
    public function index()
    {
        $exportService = new ExportService();
        $exportService->exportRegions();
    }
}
