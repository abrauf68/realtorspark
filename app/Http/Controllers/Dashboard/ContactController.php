<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $contacts = Contact::latest()->get();
            return view('dashboard.contacts.index',compact('contacts'));
        } catch (\Throwable $th) {
            Log::error('Contact Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function json(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Contact::select(['id', 'name', 'email', 'phone', 'company_name', 'created_at'])->orderBy('id','desc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return \Carbon\Carbon::parse($row->created_at)->format('F d, Y');
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '';
                        if (auth()->user()->can('view contact')) {
                            $btn .= '<a href="' . route('dashboard.contacts.show', $row->id) . '" class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Show Contact Details"><i class="ti ti-eye"></i></a>';
                        }
                        if (auth()->user()->can('delete contact')) {
                            $btn .= '<form method="POST" action="' . route('dashboard.contacts.destroy', $row->id) . '" style="display:inline-block;">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Contact"><i class="ti ti-trash"></i></button>
                                    </form>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            } catch (\Throwable $e) {
                Log::error('Contact Json Failed', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Something went wrong while fetching data.'], 500);
            }
        } else {
            Log::error('Contact Json Failed', ['error' => 'Invalid request.']);
            return response()->json(['error' => 'Invalid request.'], 400);
        }
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
        $this->authorize('view contact');
        try {
            $contact = Contact::findOrFail($id);
            return view('dashboard.contacts.show', compact('contact'));
        } catch (\Throwable $th) {
            Log::error('Contact Show Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        $this->authorize('delete contact');
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return redirect()->back()->with('success', 'Contact Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Contact Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
