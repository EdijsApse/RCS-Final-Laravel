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
        $validator = $this->validator($request);

        if ($validator->fails()) {
            return redirect('improvement')->withErrors($validator)->withSuccess('Something is wrong! Check values, there should be explanation!');
        }

        Improvement::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return redirect('improvement')->withSuccess('Good job! Improvement suggested!');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:'.implode(',', array_column(Improvement::getStatuses(), 'status'))
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $validator->errors()->first()
            ];
        }

        $improvement = Improvement::where(['id' => $request->input('improvement'), ['status', '!=', $request->input('status')]])->first();

        if ($improvement) {
            return [
                'success' => $improvement->update(['status' => $request->input('status')]),
                'error' => ""
            ];
        }

        return [
            'success' => false,
            'error' => "Looks like improvement in this stage doesnt exists!"
        ];
    }



    protected function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'description' => 'required|min:10',
            'priority' => 'required|in:'.implode(',', array_keys(Improvement::getPriorities())),
        ], [
            'priority.in' => 'Looks like priority is not valid!'
        ]);

        return $validator;
    }
}
