<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// Import the Query model
use App\Models\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuerieController extends Controller
{
    
     // Display the query submission form and user's history.
     
    public function index()
    {
        // Get queries for the logged-in user or an empty collection
        $queries = Auth::check() 
            ? Query::where('user_id', Auth::id())->latest()->get() 
            : collect();

        // Path: resources/views/auth/client/show-query.blade.php
       // return view('auth.client.show-query', compact('queries'));
        return view('show-query', compact('queries'));
    }

    
     // Store the client query. 
    public function store(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'phone'       => 'required',
            'address'     => 'required',
            'city'        => 'required',
            'country'     => 'required',
            'description' => 'required',
        ]);

        // Creating the query record
        Query::create([
            'user_id'     => Auth::id(), // Will be null if guest (اگر مہمان ہو تو نل ہوگا)
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'city'        => $request->city,
            'country'     => $request->country,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Your query has been submitted successfully!');
    }

    
     // Show a specific query and its answer.
     
    public function showAnswer($id)
    {
        $query = Query::findOrFail($id);

        // Path: resources/views/auth/client/query-answer.blade.php
        return view('query-answer', compact('query'));
    }
}