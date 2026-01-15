<?php

namespace App\Exports;

use App\Models\Peserta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PesertaExport implements FromView
{
    protected $tahun;
    protected $skema;

    public function __construct($tahun, $skema = '')
    {
        $this->tahun = $tahun;
        $this->skema = $skema;
    }

    public function view(): View
    {
        $query = Peserta::where('tahun', $this->tahun);
        if($this->skema) {
            $query->where('skema', 'like', '%'.$this->skema.'%');
        }
        
        $data = array(
            'peserta'  => $query->orderBy('nama','asc')->get(),
            'tahun'    => $this->tahun,
            'skema'    => $this->skema,
            'tanggal'  => now()->format('d-m-y'),
            'jam'      => now()->format('H.i.s'),
        );
        return view('admin/peserta/excel', $data);
    }
}