<?php

namespace App\Exports;

use App\Exports\EventExportPerSheet;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EventExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $data = Event::where('id', $this->id)->with('pendaftaran')->first();

        return view('exports.event', compact('data'));
    }
}
