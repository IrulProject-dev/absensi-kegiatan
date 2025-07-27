<?php

namespace App\Http\Controllers;

use App\Models\prasence;
use App\Models\prasenceDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class prasenceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function exportPDF(string $id)
    {
        $prasence = prasence::findOrFail($id);
        $prasenceDetail = prasenceDetail::where('prasence_id', $id)->get();

        // dd($prasenceDetail ,$prasence);

        // load view to pdf
        $pdf = Pdf::setOptions(['isRemoteEnabled' => true])
            ->loadView('pages.prasence.details.export-pdf',compact('prasence','prasenceDetail'))
            ->setPaper('a4' ,'landscape');

        return $pdf->stream("{$prasence->nama_kegiatan}.pdf" , ['Attachment' => 0]);

        exit();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prasenceDetail = prasenceDetail::findOrFail($id);

        if($prasenceDetail->tanda_tangan){
            Storage::disk('public_uploads')->delete($prasenceDetail->tanda_tangan);
        }

        $prasenceDetail->delete();

        return response()->json(['status' => 'success' ,'message'=> 'Data berhasil dihapus']);
    }
}
