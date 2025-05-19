<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jamaah;
use App\Models\Cicilan;
use App\Models\Agent;
use App\Models\Paket;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JamaahController extends Controller
{
    public function index()
    {
        $jamaah = Jamaah::all();
        $data = array(
            'title' => 'Jamaah | ',
            'datajamaah' => $jamaah,
        );
        $title = 'Delete Jamaah!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.jamaah.index', $data);
    }

    public function store(Request $request)
    {   // If no jamaah_id, it's a create operation
        $validated = $request->validate([
            'nik' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'phone' => 'required|string|max:255',
            'passpor' => 'nullable|string|max:255',
            'dp' => 'nullable|numeric',
            'tgl_berangkat' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
            'cabang_id' => 'nullable|exists:cabang,id',
            'agent_id' => 'nullable|exists:agents,id_agent',
            'paket_id' => 'nullable|exists:paket,id',
        ]);

        $validated['status'] = empty($validated['dp']) ? 'Tanpa DP' : 'Sudah DP';
        // Create a new record
        Jamaah::create($validated);

        Alert::success('Success', 'Jamaah created successfully.');

        return redirect()->route('bcabang', ['cabang' => $validated['cabang_id']]);
    }

    public function show(Jamaah $jamaah)
    {
        $cicilan = Cicilan::where('id_jamaah', $jamaah->id)->with('user')->get();

        $totalCicilan = $cicilan->sum('deposit');
        $dp = $jamaah->dp ?? 0;
        $hargaPaket = $jamaah->paket->harga_paket ?? 0;

        $sisaCicilan = $hargaPaket - ($dp + $totalCicilan);
        $maxCicilan = 5;

        // Check if cicilan is finished (no remaining balance)
        $isFinished = $sisaCicilan <= 0;

        return view('backend.cabang.cicilan', [
            'title' => 'Cicilan | ',
            'datajamaah' => $jamaah,
            'datacicilan' => $cicilan,
            'sisaCicilan' => $sisaCicilan,
            'maxCicilan' => $maxCicilan,
            'isFinished' => $isFinished, // Pass the "finished" status
        ]);
    }

    public function edit(Jamaah $jamaah, Request $request)
    {
        $data = array(
            'title' => 'Edit Jamaah | ',
            'jm' => $jamaah,
            'cabangId' => $request->input('cabang'),
            'dataagent' => Agent::all(),
            'datapaket' => Paket::all(),
        );
        return view('backend.cabang.b2edit', $data);
    }

    public function update(Request $request, Jamaah $jamaah)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'phone' => 'required|string|max:255',
            'passpor' => 'nullable|string|max:255',
            'dp' => 'nullable|numeric',
            'tgl_berangkat' => 'nullable|date',
            'cabang_id' => 'nullable|exists:cabang,id',
            'agent_id' => 'nullable|exists:agents,id_agent',
            'paket_id' => 'nullable|exists:paket,id',
        ]);
        $validated['status'] = empty($validated['dp']) ? 'Tanpa DP' : 'Sudah DP';
        $validated['updateby'] = Auth::id();
        $validated['updatetime'] = Carbon::now();

        // dd($validated);
        // Update the record
        $jamaah->update($validated);        
        Alert::success('Success', 'Jamaah updated successfully.');
        return redirect()->route('bcabang', ['cabang' => $validated['cabang_id']]);
    }

    public function destroy(Jamaah $jamaah)
    {
        // Delete related cicilan first
        $jamaah->cicilan()->delete();
        
        $jamaah->delete();
        return redirect()->back()->with('success', 'Jamaah berhasil dihapus.');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'id_jamaah' => 'required|exists:jamaah,id',
            'tgl_cicil' => 'required|date',
            'deposit'   => 'required|numeric|min:0',
        ]);

        $jamaah = Jamaah::with('paket')->findOrFail($request->id_jamaah);

        // Hitung sisa cicilan (backend version)
        $totalCicilan = Cicilan::where('id_jamaah', $jamaah->id)->sum('deposit');
        $dp = $jamaah->dp ?? 0;
        $hargaPaket = $jamaah->paket->harga_paket ?? 0;
        $sisaCicilan = $hargaPaket - ($dp + $totalCicilan);

        // Validasi tambahan: deposit tidak boleh lebih dari sisa cicilan
        if ($request->deposit > $sisaCicilan) {
            return redirect()->back()->withErrors(['deposit' => 'Deposit tidak boleh lebih dari sisa cicilan.'])->withInput();
        }

        // Simpan cicilan
        Cicilan::create([
            'id_jamaah' => $request->id_jamaah,
            'tgl_cicil' => $request->tgl_cicil,
            'deposit'   => $request->deposit,
            'user_id'   => Auth::id(),
        ]);
        
        // Hitung ulang total cicilan setelah penambahan
        $totalCicilanUpdated = Cicilan::where('id_jamaah', $jamaah->id)->sum('deposit');
        $sisaCicilanUpdated = $hargaPaket - ($dp + $totalCicilanUpdated);
    
        // Jika sisa cicilan sudah lunas, update status
        if ($sisaCicilanUpdated <= 0) {
            $jamaah->status = 'Lunas';
            $jamaah->save();
        }

        return redirect()->back()->with('success', 'Cicilan berhasil ditambahkan.');
    }

    public function hapus($id)
    {
        $cicilan = Cicilan::findOrFail($id);
        $jamaah = $cicilan->jamaah;
    
        // Delete the cicilan
        $cicilan->delete();
    
        // Recalculate sisa cicilan
        $totalCicilan = Cicilan::where('id_jamaah', $jamaah->id)->sum('deposit');
        $dp = $jamaah->dp ?? 0;
        $hargaPaket = $jamaah->paket->harga_paket ?? 0;
        $sisaCicilan = $hargaPaket - ($dp + $totalCicilan);
    
        // Update status if cicilan is not fully paid anymore
        if ($sisaCicilan > 0 && $jamaah->status === 'Lunas') {
            $jamaah->status = 'Sudah DP'; // or 'Belum Lunas', depending on your terminology
            $jamaah->save();
        }
    
        return redirect()->back()->with('success', 'Cicilan berhasil dihapus.');
    }


    public function cetakKwitansi2($id)
    {     
        $pageTitle = 'Kwitansi ';
        $detail = Cicilan::where('id', $id)->with('jamaah')->first();
        return view('backend.cabang.cetak2', [
            'pageTitle' => $pageTitle,
            'idpage' => $id,
            'cicilan' => $detail,
        ]);
    }
    
    public function checkDuplicateNama(Request $request)
    {
        $isDuplicate = Jamaah::isDuplicateNamaToday($request->nama, $request->id);
        return response()->json(['duplicate' => $isDuplicate]);
    }
}
