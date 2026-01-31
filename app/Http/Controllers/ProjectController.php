<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    // ========== MARKETING ==========
    public function marketingIndex()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Project Management',
            'menuMarketingProject' => 'active',
            'projects' => Project::where('marketing_user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get(),
        ];
        return view('marketing.project.index', $data);
    }

    public function marketingCreate()
    {
        $data = [
            'title' => 'Buat Project Baru',
            'menuMarketingProject' => 'active',
        ];
        return view('marketing.project.create', $data);
    }

    public function marketingStore(Request $request)
    {
        $request->validate([
            'skema' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'timeline' => 'required|string|max:255',
        ], [
            'skema.required' => 'Skema tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'timeline.required' => 'Timeline tidak boleh kosong',
        ]);

        Project::create([
            'marketing_user_id' => Auth::id(),
            'skema' => $request->skema,
            'tanggal' => $request->tanggal,
            'timeline' => $request->timeline,
            'status' => 'waiting_operasional',
        ]);

        return redirect()->route('marketing.project')->with('success', 'Project berhasil dibuat');
    }

    public function marketingShow($id)
    {
        $project = Project::where('marketing_user_id', Auth::id())->findOrFail($id);
        $data = [
            'title' => 'Detail Project',
            'menuMarketingProject' => 'active',
            'project' => $project,
        ];
        return view('marketing.project.show', $data);
    }

    public function marketingEdit($id)
    {
        $project = Project::where('marketing_user_id', Auth::id())
            ->where('status', 'draft')
            ->findOrFail($id);
        
        $data = [
            'title' => 'Edit Project',
            'menuMarketingProject' => 'active',
            'project' => $project,
        ];
        return view('marketing.project.edit', $data);
    }

    public function marketingUpdate(Request $request, $id)
    {
        $request->validate([
            'skema' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'timeline' => 'required|string|max:255',
        ], [
            'skema.required' => 'Skema tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'timeline.required' => 'Timeline tidak boleh kosong',
        ]);

        $project = Project::where('marketing_user_id', Auth::id())
            ->where('status', 'draft')
            ->findOrFail($id);

        $project->update([
            'skema' => $request->skema,
            'tanggal' => $request->tanggal,
            'timeline' => $request->timeline,
        ]);

        return redirect()->route('marketing.project')->with('success', 'Project berhasil diupdate');
    }

    public function marketingDestroy($id)
    {
        $project = Project::where('marketing_user_id', Auth::id())
            ->where('status', 'draft')
            ->findOrFail($id);
        
        $project->delete();

        return redirect()->route('marketing.project')->with('success', 'Project berhasil dihapus');
    }

    // ========== OPERASIONAL ==========
    public function operasionalIndex()
    {
        $data = [
            'title' => 'Project List - Operasional',
            'menuOperasionalProject' => 'active',
            'projects' => Project::with('marketingUser')
                ->whereIn('status', ['waiting_operasional', 'waiting_supporting', 'completed'])
                ->orderBy('created_at', 'desc')
                ->get(),
        ];
        return view('operasional.project.index', $data);
    }

    public function operasionalShow($id)
    {
        $project = Project::with('marketingUser')->findOrFail($id);
        $data = [
            'title' => 'Detail Project',
            'menuOperasionalProject' => 'active',
            'project' => $project,
        ];
        return view('operasional.project.show', $data);
    }

    public function operasionalEdit($id)
    {
        $project = Project::where('status', 'waiting_operasional')->findOrFail($id);
        $data = [
            'title' => 'Catat Kebutuhan Project',
            'menuOperasionalProject' => 'active',
            'project' => $project,
        ];
        return view('operasional.project.edit', $data);
    }

    public function operasionalUpdate(Request $request, $id)
    {
        $request->validate([
            'catatan_operasional' => 'nullable|string',
        ]);

        $project = Project::where('status', 'waiting_operasional')->findOrFail($id);

        $project->update([
            'need_surat_tugas' => $request->has('need_surat_tugas'),
            'need_invoice' => $request->has('need_invoice'),
            'need_jadwal_meeting' => $request->has('need_jadwal_meeting'),
            'catatan_operasional' => $request->catatan_operasional,
            'operasional_submitted_at' => now(),
            'status' => 'waiting_supporting',
        ]);

        return redirect()->route('operasional.project')->with('success', 'Kebutuhan project berhasil dicatat');
    }

    // ========== SUPPORTING ==========
    public function supportingIndex()
    {
        $data = [
            'title' => 'Project List - Supporting',
            'menuSupportingProject' => 'active',
            'projects' => Project::with('marketingUser')
                ->whereIn('status', ['waiting_supporting', 'completed'])
                ->orderBy('created_at', 'desc')
                ->get(),
        ];
        return view('supporting.project.index', $data);
    }

    public function supportingShow($id)
    {
        $project = Project::with('marketingUser')->findOrFail($id);
        $data = [
            'title' => 'Detail Project',
            'menuSupportingProject' => 'active',
            'project' => $project,
        ];
        return view('supporting.project.show', $data);
    }

    public function supportingEdit($id)
    {
        $project = Project::where('status', 'waiting_supporting')->findOrFail($id);
        $data = [
            'title' => 'Isi Kebutuhan Project',
            'menuSupportingProject' => 'active',
            'project' => $project,
        ];
        return view('supporting.project.edit', $data);
    }

    public function supportingUpdate(Request $request, $id)
    {
        $project = Project::where('status', 'waiting_supporting')->findOrFail($id);

        $rules = [
            'catatan_supporting' => 'nullable|string',
            'jadwal_meeting_tanggal' => 'nullable|date',
            'jadwal_meeting_waktu' => 'nullable|date_format:H:i',
        ];

        if ($project->need_surat_tugas) {
            $rules['surat_tugas_file'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }

        if ($project->need_invoice) {
            $rules['invoice_file'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }

        if ($project->need_jadwal_meeting) {
            $rules['jadwal_meeting_tanggal'] = 'required|date';
            $rules['jadwal_meeting_waktu'] = 'required|date_format:H:i';
        }

        $request->validate($rules, [
            'surat_tugas_file.required' => 'File surat tugas wajib diupload',
            'invoice_file.required' => 'File invoice wajib diupload',
            'jadwal_meeting_tanggal.required' => 'Tanggal meeting wajib diisi',
            'jadwal_meeting_waktu.required' => 'Waktu meeting wajib diisi',
        ]);

        $updateData = [
            'catatan_supporting' => $request->catatan_supporting,
            'supporting_submitted_at' => now(),
            'status' => 'completed',
        ];

        // Upload Surat Tugas
        if ($request->hasFile('surat_tugas_file')) {
            if ($project->surat_tugas_file) {
                Storage::disk('public')->delete($project->surat_tugas_file);
            }
            $updateData['surat_tugas_file'] = $request->file('surat_tugas_file')->store('projects/surat-tugas', 'public');
        }

        // Upload Invoice
        if ($request->hasFile('invoice_file')) {
            if ($project->invoice_file) {
                Storage::disk('public')->delete($project->invoice_file);
            }
            $updateData['invoice_file'] = $request->file('invoice_file')->store('projects/invoice', 'public');
        }

        // Jadwal Meeting
        if ($project->need_jadwal_meeting) {
            $updateData['jadwal_meeting_tanggal'] = $request->jadwal_meeting_tanggal;
            $updateData['jadwal_meeting_waktu'] = $request->jadwal_meeting_waktu;
        }

        $project->update($updateData);

        return redirect()->route('supporting.project')->with('success', 'Kebutuhan project berhasil dilengkapi');
    }
}