<?php

namespace App\Http\Controllers\Quickcount;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Quickcount;
use Illuminate\Http\Request;

class QuickcountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private Quickcount $quickcount;
    private Candidate $candidate;

    public function __construct(Quickcount $quickcount, Candidate $candidate) {
        $this->quickcount = $quickcount;
        $this->candidate = $candidate;
    }

    public function index()
    {
        $quickcounts = $this->quickcount->all();
        $candidates = $this->candidate->all();
        return view('pages.relawan.quickcount.index', compact('quickcounts', 'candidates'));
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
        //
    }
}
