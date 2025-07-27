<?php

namespace App\Http\Controllers;

use App\DataTables\prasenceDetailsDataTable;
use App\DataTables\prasencesDataTable;
use App\Models\prasence;
use App\Models\prasenceDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PrasenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(prasencesDataTable $dataTable)
    {
        // $data = prasence::all();
        $dataTable->with('user_id', auth()->user()->id);
        return $dataTable->render('pages.prasence.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.prasence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan'=> 'required',
            'tgl_kegiatan'=> 'required',
            'waktu_mulai'=> 'required',
        ]);

        $data = [
            'nama_kegiatan' => $request->nama_kegiatan,
            'slug' => Str::slug($request->nama_kegiatan),
            'tgl_kegiatan' => $request->tgl_kegiatan. ' ' . $request->waktu_mulai,
            'user_id' => auth()->user()->id,
        ];

        prasence::create($data);

        return redirect()->route('prasence.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, prasenceDetailsDataTable $dataTable)
    {
        $prasence = Prasence::where('user_id', auth()->user()->id)->findOrFail($id);
        // $prasenceDetail = prasenceDetail::where('prasence_id', $id)->get();
        return $dataTable->render('pages.prasence.details.index',compact('prasence' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prasence = prasence::where('user_id', auth()->user()->id)->findOrFail($id);

        return view('pages.prasence.edit',compact('prasence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nama_kegiatan'=> 'required',
            'tgl_kegiatan'=> 'required',
            'waktu_mulai'=> 'required',
        ]);

        // dd($request->all());

        $data = [
            'nama_kegiatan'=> $request->nama_kegiatan,
            'slug'=> Str::slug($request->nama_kegiatan),
            'tgl_kegiatan'=> $request->tgl_kegiatan.' '. $request->waktu_mulai,
        ];

        prasence::where('user_id', auth()->user()->id)->findOrFail($id)->update($data);


        return redirect()->route('prasence.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prasence = prasence::where('user_id', auth()->user()->id)->findOrFail($id);
        $prasenceDetail = prasenceDetail::where('prasence_id', $id)->get();
        foreach($prasenceDetail as $pd){
            if($pd->tanda_tangan){
                Log::info('Mencoba menghapus file: ' . $pd->tanda_tangan);
                Storage::disk('public_uploads')->delete($pd->tanda_tangan);
            }
            $pd->delete();
        }


        //detete kegiatan
        prasence::destroy($id);

        return response()->json(['status' => 'success' ,'message'=> 'Data berhasil dihapus']);
    }
}
