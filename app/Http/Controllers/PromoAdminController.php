<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromoAdminController extends Controller
{
    public function index()
    {
        return view('admin.data-promo');
    }

    public function data_promo_datatables()
    {
        $query = Promo::all();

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('mode',function($row){
            return '
            <span class="px-2 py-1 text-xs rounded-full
                '.($row->mode == 'homecare'
                    ? 'bg-orange-100 text-orange-700'
                    : 'bg-blue-100 text-blue-700').'">
                '.ucfirst($row->mode).'
            </span>';
        })
        ->addColumn('nilai',function($row){
            if ($row->type == 'percentage') {
                return $row->value;
            } else {
                return rupiah($row->value);
            }
        })
        ->addColumn('periode',function($row){
            return 
            ''.$row->start_date->format("d M Y")
            .'-'
            .$row->end_date->format("d M Y").'';
        })
        ->addColumn('status',function($row){
            return '<span class="' .
        ($row->is_active ? 'bg-green-100 rounded-lg text-green-700 p-1' : 'bg-red-100 rounded-lg p-1 text-red-700') .
        '">' .
        ($row->is_active ? 'Aktif' : 'Nonaktif') .
        '</span>';
        })
        ->addColumn('aksi',function($row){
            return '
        <button class="btn-edit bg-blue-600 text-white px-3 py-1 rounded-lg"
        data-id="'.$row->id.'">
            Edit
        </button>
        <button class="btn-hapus bg-red-600 text-white px-3 py-1 rounded-lg" data-id="'.$row->id.'">
            Hapus
        </button>';
        })
        ->rawColumns(['mode','nilai','periode','status','aksi'])
        ->make(true);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'mode' => 'required|in:center,homecare',
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'minimum_transaction' => 'nullable|numeric|min:0',
                'quota' => 'nullable|integer|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'is_active' => 'nullable'
            ]);

            // handle checkbox
            $data['is_active'] = $request->has('is_active');

            $promo = Promo::create($data);

            // jika request AJAX → return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Promo berhasil ditambahkan',
                    'data' => $promo
                ]);
            }

            // fallback jika bukan AJAX
            return redirect()->route('promo.index')
                ->with('success', 'Promo ditambahkan');

        } catch (\Illuminate\Validation\ValidationException $e) {

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            throw $e;
        } catch (\Throwable $e) {

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan server'
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return response()->json([
            'id' => $promo->id,
            'title' => $promo->title,
            'description' => $promo->description,
            'mode' => $promo->mode,
            'type' => $promo->type,
            'value' => $promo->value,
            'minimum_transaction' => $promo->minimum_transaction,
            'start_date' => $promo->start_date->format('Y-m-d'),
            'end_date' => $promo->end_date->format('Y-m-d'),
            'is_active' => $promo->is_active,
        ]);
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mode' => 'required|in:center,homecare',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'minimum_transaction' => 'nullable|numeric|min:0',
            'quota' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable'
        ]);
    
        $data['is_active'] = $request->has('is_active');
    
        $promo->update($data);
    
        return response()->json([
            'success' => true,
            'message' => 'Promo berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        Promo::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Promo berhasil dihapus'
        ]);
    }
}