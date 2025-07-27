<?php

namespace App\Http\Controllers;
use App\DataTables\AbsenDataTable;
use App\Models\prasence;
use App\Models\prasenceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index($slug, AbsenDataTable $dataTable)
    {
        $prasence = prasence::where('slug', $slug)->firstOrFail();
        return $dataTable->with('prasence_id', $prasence->id)->render('pages.absen.index', compact('prasence'));
    }

    public function save(Request $request, string $id)
    {
        $prasence = prasence::findOrFail($id);
        $request->validate([
            'name'=> 'required',
            'jabatan'=> 'required',
            'asal_instansi'=> 'required',
            'signature'=> 'required'
        ]);

        $prasenceDetail = new prasenceDetail();
        $prasenceDetail->prasence_id = $prasence->id;
        $prasenceDetail->name = $request->name;
        $prasenceDetail->jabatan = $request->jabatan;
        $prasenceDetail->asal_instansi = $request->asal_instansi;

        // Dekode base64
        $base64_image = $request->signature;
        // Pisahkan header data URI (misal: data:image/png;base64,) dari data sebenarnya
        $data = explode(',', $base64_image);
        // Ambil bagian data base64 saja
        $file_data = base64_decode($data[1]);

        //generate name file
        $uniqChar = date('YmdHis').uniqid();
        $signature = "tanda-tangan/{$uniqChar}.png";

        //simpan gambar
        Storage::disk('public_uploads')->put($signature,$file_data);

        $prasenceDetail->tanda_tangan = $signature;
        $prasenceDetail->save();

        return redirect()->back();
    }


}
