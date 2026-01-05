<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tugas;
use App\Exports\TugasExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TugasController extends Controller
{
    public function index(){
        $user = Auth::user();

        if ($user->jabatan=='Admin') {
        $data = array(
            'title'             => 'Data Tugas',
            'menuAdminTugas'    => 'active',
            'tugas'             =>  Tugas::with('user')->get(),  
        );
        return view('admin/tugas/index', $data);
        }else{
        $data = array(
            'title'             => 'Data Tugas',
            'menuKaryawanTugas'    => 'active',
            'tugas'                => Tugas::with('user')->where('user_id',$user->id)->first(),
        );
        return view('karyawan/tugas/index', $data); 
        }


    }

    public function create(){
       $data = array(
            'title'             => 'TambahData Tugas',
            'menuAdminTugas'    => 'active',
            'user'              => User::where('jabatan', 'Karyawan')->where('is_tugas', false)->get(),
        );
        return view('admin/tugas/create', $data); 
    }

        public function store(Request $request){
        $request->validate([
            'user_id'              =>  'required',
            'tugas'                =>  'required',
            'tanggal_mulai'        =>  'required',
            'tanggal_selesai'      =>  'required',
        ],[
            'user_id.required'           => 'Nama tidak boleh kosong',
            'tugas.required'             => 'Tugas tidak boleh kosong',
            'tanggal_mulai.required'     => 'Tanggal mulai tidak boleh kosong',
            'tanggal_selesai.required'   => 'Tanggal selesai tidak boleh kosong',
        ]);

        $user = User::findOrFail($request->user_id);
        $tugas = new Tugas;
        $tugas->user_id = $request->user_id;
        $tugas->tugas = $request->tugas;
        $tugas->tanggal_mulai = $request->tanggal_mulai;
        $tugas->tanggal_selesai = $request->tanggal_selesai;
        $tugas->save();
        $user->is_tugas = true;
        $user->save();

        return redirect()->route('user')->with('success', 'Data berhasil ditambahkan');

    }

       public function edit($id){
       $data = array(
            'title'             => 'Edit Data Tugas',
            'menuAdminTugas'    => 'active',
            'tugas'             => Tugas::with('user')->findOrFail($id),
        );
        return view('admin/tugas/update', $data); 
    }

            public function update(Request $request, $id){
        $request->validate([
            'tugas'                =>  'required',
            'tanggal_mulai'        =>  'required',
            'tanggal_selesai'      =>  'required',
        ],[
            'tugas.required'             => 'Tugas tidak boleh kosong',
            'tanggal_mulai.required'     => 'Tanggal mulai tidak boleh kosong',
            'tanggal_selesai.required'   => 'Tanggal selesai tidak boleh kosong',
        ]);
        $tugas = Tugas::findOrFail($id);
        $tugas->tugas = $request->tugas;
        $tugas->tanggal_mulai = $request->tanggal_mulai;
        $tugas->tanggal_selesai = $request->tanggal_selesai;
        $tugas->save();

        return redirect()->route('user')->with('success', 'Data berhasil Di Edit');

    }

      public function destroy($id){
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();
        $user  = User::where('id', $tugas->user_id)->first();
        $user-> is_tugas = false;
        $user->save();

        return redirect()->route('tugas')->with('success', 'Data berhasil dihapus');
    }

        public function excel(){
        $filename = now()->format('d-m-y_H.i.s');
        return Excel::download(new TugasExport, 'DataTugas_'.$filename.'.xlsx');
    }

        public function pdf(){
       $user = Auth::user();    
       $filename = now()->format('d-m-y_H.i.s');

       if ($user->jabatan=='Admin') {
           $data = array(
           'tugas'     => Tugas::with('user')->get(),
           'tanggal'   => now()->format('d-m-y'),
           'jam'       => now()->format('H.i.s'),
       );
       
       $pdf = Pdf::loadView('admin/tugas/pdf', $data);
       return $pdf->setPaper('a4', 'landscape')->stream('DataTugas_'.$filename.'.pdf');
       } else {
        $data = array(
           'tanggal'   => now()->format('d-m-y'),
           'jam'       => now()->format('H.i.s'),
           'tugas'     => Tugas::with('user')->where('user_id',$user->id)->first(),
       );
       
       $pdf = Pdf::loadView('karyawan/tugas/pdf', $data);
       return $pdf->setPaper('a4', 'portrait')->stream('DataTugas_'.$filename.'.pdf');
       }
       


    }
}
