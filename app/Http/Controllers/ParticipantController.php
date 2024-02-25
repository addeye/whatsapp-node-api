<?php

namespace App\Http\Controllers;

use App\Exports\ParticipantExport;
use App\Imports\ParticipantImport;
use App\Models\Group;
use App\Models\Participant;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participant = Participant::query();

        $sort = request('sort_val') ?? 'DESC';
        if (request('sort_name') == 'name') {
            $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
            $participant->orderBy('name', request('sort_val'));
        }

        if (request('sort_name') == 'phone') {
            $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
            $participant->orderBy('phone', request('sort_val'));
        }

        if (request('sort_name') == 'group_id') {
            $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
            $participant->orderBy('group_id', request('sort_val'));
        }


        if (request('cari')) {
            $participant->where(function ($q) {
                $q->where('name', 'LIKE', '%' . request('cari') . '%')
                    ->orWhere('phone', 'LIKE', '%' . request('cari') . '%')
                    ->orWhere('group_id', 'LIKE', '%' . request('cari') . '%');
            });
        }

        $participant = $participant->orderBy('created_at', $sort)->paginate()->withQueryString();

        return view('pages.participant.list', [
            'data' => $participant->withPath('participant'),
            'sort' => $sort
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Group $group)
    {
        return view('pages.participant.add', [
            'group' => $group
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required'
        ];

        $messages = [
            'name.required' => 'Name Wajib terisi!',
            'phone.required' => 'Phone Wajib terisi!'
        ];


        $request->validate($rules, $messages);
        $datarow = $request->all();

        $datarow['group_id'] = $group->id;

        Participant::create($datarow);

        return redirect('group/' . $group->id)->with('success', 'Participant Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Participant $participant)
    {
        return view('pages.participant.detail', [
            'data' => $participant
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Participant $participant)
    {
        return view('pages.participant.edit', [
            'data' => $participant,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participant $participant)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required'
        ];

        $messages = [
            'name.required' => 'Name Wajib terisi!',
            'phone.required' => 'Phone Wajib terisi!'
        ];


        $request->validate($rules, $messages);
        $datarow = $request->all();

        $participant->update($datarow);

        return redirect('group/'.$participant->group_id)->with('success', 'Participant Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participant $participant)
    {
        $group_id = $participant->group_id;
        $participant->delete();
        return redirect('group/' . $group_id)->with('success', 'Participant Deleted');
    }

    public function export()
    {
        return Excel::download(new ParticipantExport, 'participants.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new ParticipantImport($request->group_id), $request->file('file'));

        return redirect('group/' . $request->group_id)->with('success', 'All good!');
    }
}
