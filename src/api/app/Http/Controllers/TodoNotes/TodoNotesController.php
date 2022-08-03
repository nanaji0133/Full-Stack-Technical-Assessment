<?php

namespace App\Http\Controllers\TodoNotes;
 
use App\Models\Todonotes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Carbon\Carbon;

class TodoNotesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    // get todo notes of logged in user and sort them using date
    public function getAllTodoNotes(){
        $todoNotes = Auth::user()->todonotes()->get();
        return response()->json(['notes' => $todoNotes]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'note' => 'required'
        ]);

        if(Auth::user()->todonotes()->Create([
            'note' => $request['note'],
            'title' => $request['title']
            // 'completed_at' => Carbon::now()
        ])){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }

    }

    public function markTodoNotesDone(Request $request, $todo_id){
        $todoNotes = Todonotes::where('id', $todo_id)->first();
        $todoNotes -> note="Done";
        $todoNotes -> completed_at = new Carbon;
        $todoNotes->save();
        return response()->json(['status' => 'success', 'todonotes' => $todoNotes]);
    }

    public function markTodoNotesPending(Request $request, $todo_id){
        $todoNotes = Todonotes::where('id', $todo_id)->first();
        $todoNotes -> note="Pending";
        $todoNotes -> completed_at = null;
        $todoNotes->save();
        return response()->json(['status' => 'success', 'todonotes' => $todoNotes]);
    }

    
}


// .sort((
//     function($x, $y) {
//         return (new Date($y.created_at) - new Date($x.created_at));
//     }
// ))