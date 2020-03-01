<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Improvement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ImprovementController extends Controller
{
    public function index()
    {
        return view('improvement.index', [
            'improvements' => Improvement::orderBy('updated_at', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $success = false;
        $msg = '';

        $validator = Validator::make($data, [
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'priority' => 'required|in:'.implode(array_keys(Improvement::getPriorities()), ','),
        ], [
            'priority.in' => 'Looks like priority is not valid!'
        ]);

        $data['user_id'] = Auth::id();

        if ($validator->fails()) {
            $success = false;
            $msg = $validator->errors()->first();
        } else {
            if (Improvement::create($data)) {
                $success = true;
            } else {
                $success = false;
                $msg = 'Cant create improvement!';
            }
        }

        return [
            'success' => $success,
            'error' => $msg
        ];
    }
}
