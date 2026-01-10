<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PesertaExport implements FromView
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $data = array(
            'peserta'  => Peserta::where('tahun', $this->tahun)->orderBy('nama','asc')->get(),
            'tahun'    => $this->tahun,
            'tanggal'  => now()->format('d-m-y'),
            'jam'      => now()->format('H.i.s'),
        );
        return view('admin/peserta/excel', $data);
    }
}