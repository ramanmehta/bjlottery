<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MissionSubmission;
use App\Models\User;
use App\Models\Mission;

class MissionSubmissionController extends Controller
{
    public function index($id = null)
    {
        $submissions = MissionSubmission::with(['mission', 'user'])
            ->orderBy('id', 'DESC')
            ->when(!is_null($id), function ($q) use ($id) {
                $q->where('mission_id', $id);
            })
            ->paginate(10);;

        return view('admin.submissions.index', compact('submissions'));
    }

    public function create()
    {
        return view('admin.submissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mission_id' => 'required',
            'user_id' => 'required',
            'proof' => 'required',
        ]);

        MissionSubmission::create($request->all());

        return redirect()->route('submissions.index')
            ->with('success', 'Submission created successfully.');
    }

    public function show(MissionSubmission $submission)
    {
        return view('admin.submissions.show', compact('submission'));
    }

    public function edit(MissionSubmission $submission)
    {
        return view('admin.submissions.edit', compact('submission'));
    }

    public function update(Request $request, MissionSubmission $submission)
    {
        $request->validate([
            'mission_id' => 'required',
            'user_id' => 'required',
            'proof' => 'required',
        ]);

        $submission->update($request->all());

        return redirect()->route('submissions.index')
            ->with('success', 'Submission updated successfully.');
    }

    public function destroy(MissionSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('submissions.index')
            ->with('success', 'Submission deleted successfully.');
    }
}
