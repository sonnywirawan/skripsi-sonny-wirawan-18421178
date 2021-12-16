<?php

namespace App\Exports;

use App\Models\Event;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EventExportPerSheet implements FromView, ShouldAutoSize
{
    public function __construct($id, $i)
    {
        $this->id = $id;
        $this->sheet = $i;
    }

    public function view(): View
    {
        $data = Event::where('id', $this->id)->with(['pendaftaran' => function($pendaftar) {
            return $pendaftar->with('kabupaten')->get();
        }])->first();

        $sheet = $this->sheet;
        return view('exports.event', compact('data', 'sheet'));
    }
}
