<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Jamaah;
use App\Models\Agent;
use App\Models\Paket;
use App\Models\Privilage;
use App\Models\Cicilan;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class CabangController extends Controller
{
    public function index()
    {
        $cabang = Cabang::all();
        $data = array(
            'title' => 'Cabang | ',
            'datacabang' => $cabang,
        );
        $title = 'Delete Cabang!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('backend.cabang.index', $data);
    }

    public function create()
    {
        $lantai = Cabang::all();
        $data = array(
            'title' => 'Add Cabang | ',
            'datalantai' => $lantai,
        );
        return view('backend.cabang.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Cabang::create($request->all());
        Alert::success('Success', 'cabang created successfully.');

        return redirect()->route('cabang.index');
    }

    public function show(Cabang $cabang)
    {
        $data = array(
            'title' => 'View Cabang | ',
        );
        return view('backend.cabang.show', $data);
    }

    public function edit(Cabang $cabang)
    {
        $data = array(
            'title' => 'Edit Cabang | ',
            'cabang' => $cabang,
        );
        return view('backend.cabang.edit', $data);
    }

    public function update(Request $request, Cabang $cabang)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $cabang->update($request->all());
        Alert::success('Success', 'cabang updated successfully.');

        return redirect()->route('cabang.index');
    }

    public function destroy(Cabang $cabang)
    {
        $cabang->delete();
        Alert::success('Success', 'cabang deleted successfully.');

        return redirect()->route('cabang.index');
    }

    public function bcabang(Request $request)
    {
        $cabangId = $request->input('cabang');
        $tgl_berangkat = $request->input('tgl_berangkat');
        $cabang = $cabangId ? Cabang::find($cabangId) : null;

        if ($cabangId) {
            $query = Jamaah::where('cabang_id', $cabangId)
                        ->with(['agent', 'cabang', 'updatebyuser', 'paket']);
    
            if ($tgl_berangkat) {
                $query->whereDate('tgl_berangkat', Carbon::parse($tgl_berangkat)->toDateString());
            }
    
            $cabangs = $query->get();
        } else {
            $cabangs = Cabang::getCabangsForAuthenticatedUser();
        }

        $cabangsWithColors = $cabangs->map(function ($jamaah) {
            $jamaah->randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Random color
        
            $totalCicilan = Cicilan::where('id_jamaah', $jamaah->id)->sum('deposit');
            $dp = $jamaah->dp ?? 0;
            $hargaPaket = $jamaah->paket->harga_paket ?? 0;
            $sisaCicilan = $hargaPaket - ($dp + $totalCicilan);
        
            // Determine status based on cicilan logic
            if ($sisaCicilan <= 0) {
                $jamaah->cicilan_status = 'Lunas';
            } elseif ($dp > 0) {
                $jamaah->cicilan_status = 'Sudah DP';
            } else {
                $jamaah->cicilan_status = 'Tanpa DP';
            }
        
            return $jamaah;
        });
        
        $title = 'Delete Jamaah!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        $data = array(
            'title' => $cabang ? $cabang->nama_cabang . ' | ' : 'B2C |',
            'datacabang' => $cabangsWithColors,
            'cabangId' => $cabangId,
            'namacabang' => $cabang->nama_cabang ?? '',
            'dataagent' => Agent::all(),
            'datapaket' => Paket::all(),
            'koderole' => Privilage::getRoleKodeForAuthenticatedUser(),
        );
        // dd($data['datacabang']);
        return view($cabangId ? 'backend.cabang.b2cabang' : 'backend.cabang.b2c', $data);
    }

    public function cetakKwitansi($id)
    {     
        $pageTitle = 'Kwitansi ';
        $detail = Jamaah::where('id', $id)->first();
        return view('backend.cabang.cetak', [
            'pageTitle' => $pageTitle,
            'idpage' => $id,
            'jamaah' => $detail,
        ]);
    }
}
