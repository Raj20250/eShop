<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
// Import Query model
use App\Models\Query;
use Illuminate\Http\Request;

class QuerieController extends Controller
{
    /**
     * Display all queries in a table.
     *
     */
    public function index()
    {
        // Fetch all user queries
        $queries = Query::latest()->get();
        return view('auth.admin.show-query', compact('queries'));
    }

    /**
     * Show the detailed query and reply form.
     *
     */
    public function edit($id)
    {
        // Find the specific query by ID
        $query = Query::findOrFail($id);
        
        // Return the reply view page
        return view('auth.admin.reply-query', compact('query'));
    }

    /**
     * Save the admin's reply.
     * 
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required'
        ]);
// Find the query and update the reply
        $query = Query::findOrFail($id);
        $query->update([
            'reply' => $request->reply
        ]);

        // Redirect back to the main list with success message
        return redirect()->route('admin.queries.index')->with('success', 'Reply sent!');
    }
}