<?php

namespace App\Http\Controllers;

use App\Exports\GroupExport;
use App\Models\Group;
use App\Models\Participant;
use App\Models\Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\FuncCall;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group = Group::query();

        $sort = request('sort_val') ?? 'DESC';
        if (request('sort_name') == 'name') {
            $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
            $group->orderBy('name', request('sort_val'));
        }

        if (request('sort_name') == 'description') {
            $sort = $sort == 'DESC' ? 'ASC' : 'DESC';
            $group->orderBy('description', request('sort_val'));
        }


        if (request('cari')) {
            $group->where(function ($q) {
                $q->where('name', 'LIKE', '%' . request('cari') . '%')
                    ->orWhere('description', 'LIKE', '%' . request('cari') . '%');
            });
        }

        $group = $group->orderBy('created_at', $sort)->paginate()->withQueryString();

        return view('pages.group.list', [
            'data' => $group->withPath('group'),
            'sort' => $sort
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.group.add', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $messages = [
            'name.required' => 'Nama Wajib terisi!',
            'description.required' => 'Deskripsi Wajib terisi!'
        ];


        $request->validate($rules, $messages);
        $datarow = $request->all();



        Group::create($datarow);

        return redirect('group')->with('success', 'Group Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {

        $participant = Participant::query();

        $participant->where('group_id', $group->id);

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

        return view('pages.group.detail', [
            'group' => $group,
            'data' => $participant->withPath('participant'),
            'sort' => $sort
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('pages.group.edit', [
            'data' => $group,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];

        $messages = [
            'name.required' => 'Nama Wajib terisi!',
            'description.required' => 'Deskripsi Wajib terisi!'
        ];


        $request->validate($rules, $messages);
        $datarow = $request->all();



        $group->update($datarow);

        return redirect('group')->with('success', 'Group Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {

        $group->delete();
        return redirect('group')->with('success', 'Group Deleted');
    }

    public function export()
    {
        return Excel::download(new GroupExport, 'groups.xlsx');
    }

    public function createGroup(Group $group)
    {
        if($group->server){
            return redirect('group/'.$group->id);
        }

        if($group->participant->count() == 0){
            return redirect('group/'.$group->id);
        }

        $setting = Setting::find(1);
        $base_url = $setting->base_url;

        $client = new Client();
        $url = $base_url .'/api/createGroup';

        $particpants = [];

        foreach ($group->participant as  $participant) {

            $particpants[] = $participant->phone.'@c.us';
        }

        $data = [
            'title' => $group->name,
            'listgroups' => $particpants
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => $data
            ]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);

                $group->update([
                    'server' => $data['gid']['server'],
                    'user' => $data['gid']['user'],
                    'serialized' => $data['gid']['_serialized'],
                ]);

                $participants = $data['participants'];
                foreach ($participants as $key => $p) {
                    $number_only = explode('@', $key)[0];

                    Participant::where('phone', $number_only)->update([
                        'is_joined' => 1,
                        'serialized' => $key
                    ]);
                }

                return redirect('group/' . $group->id)->with('success', 'Group Created')->with('data', $data);

                // return response()->json($data, 200);
            } else {
                return response()->json(['error' => 'Gagal mengambil data dari API'], 500);
            }
        } catch (ClientException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'body' => json_decode($e->getResponse()->getBody()->getContents(), true),
                'request' => $e->getRequest(),
                'status' => $e->getResponse()->getStatusCode(),
                'url' => $url,
                'data' => $data
            ]);
        }
    }
}
