<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function index(){
        $tasks = Task::Paginate(3);
        return response()->json($tasks); 
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ]);
        $task = new Task();
        $task->name = $request->input('name') ;
        $task->description = $request->input('description') ;
        $task->save();
        
        if($task){
            $tasks = Task::all();
            return response()->json($tasks,200);
        }else{

            return response()->json(['message' =>'error']);
        }
    }

    public function destroy(Request $request){
        $task = Task::destroy($request->input('id'));
        if($task){
            $tasks = Task::all();
            return response()->json($tasks,200);
        }else{
            return response()->json(['message' =>'error']);
        }

    }
}
