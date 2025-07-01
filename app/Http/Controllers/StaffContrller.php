<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;

class StaffContrller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/staff/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/staff/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,user_email',
            'mobile' => 'required|digits:10',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        dd($validate);
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

    // public function get_records(Request $request){
    //     if ($request->ajax()) {
    //     $data = User::query();
    //         return DataTables::of($data)->make(true);
    //     }
    // }
}
