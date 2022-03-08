<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todolist::query()
            ->where('user_id', Auth::user()->id)
            ->orderBy('order')
            ->get();

        return response()->json($todos, 200);
    }
}