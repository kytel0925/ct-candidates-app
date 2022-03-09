<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function markComplete(Todolist $todo)
    {
        if ($todo->is_completed == 0) {
            $todo->is_completed = 1;
        } else {
            $todo->is_completed = 0;
        }

        $todo->save();

        return response()->json($todo, 200);
    }

    public function reorder(Request $request)
    {
        $this->validate($request, [
            'order' => 'required|array',
        ]);

        $order = $request->input('order');

        DB::transaction(function () use ($order) {
            foreach ($order as $value) {
                Todolist::find($value['id'])->update(['order' => $value['order']]);
            }
        });

        return response()->json([], 204);
    }

    public function store(Request $request)
    {
        $postData = $this->validate($request, [
            'description' => ['required', 'min:3'],
            'date' => ['sometimes', 'date'],
        ]);

        $todo = Todolist::create([
            'description' => $postData['description'],
            'ends_at' => $postData['date'],
            'user_id' => Auth::user()->id,
        ]);

        return response()->json($todo, 201);
    }

    public function remove(Request $request)
    {
        $postData = $this->validate($request, [
            'id' => ['required', 'exists:todos,id'],
        ]);

        Todolist::where('id', $postData['id'])->delete();

        return response()->json("", 201);
    }
}