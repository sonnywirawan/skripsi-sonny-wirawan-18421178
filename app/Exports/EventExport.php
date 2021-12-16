<?php

namespace App\Exports;

use App\Exports\EventExportPerSheet;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EventExport implements ShouldAutoSize, WithMultipleSheets
{
    use Exportable;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function sheets(): array
    {
        $sheets = [];

        for ($i = 0; $i < 2; $i++) {
            $sheets[] = new EventExportPerSheet($this->id, $i);
        }

        return $sheets;
    }

    // public function view(): View
    // {
    //     $data = Event::where('id', $this->id)->with(['pendaftaran' => function($pendaftar) {
    //         return $pendaftar->with('kabupaten')->get();
    //     }])->first();
    //     return view('exports.event', compact('data'));
    // }
}
