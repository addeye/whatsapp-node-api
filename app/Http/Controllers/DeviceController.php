<?php

namespace App\Http\Controllers;

use App\Exports\DeviceExport;
use App\Models\Device;
use App\Models\Setting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $device = Device::find(1);

        if($device->phone == null){
            return view('pages.device.edit', [
                'data' => $device,
            ]);
        }else{
            return view('pages.device.detail', [
                'data' => $device,
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.device.add', []);
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
            'device_id' => 'required',
            'phone' => 'required',
            'status' => 'required'
        ];

        $messages = [
            'device_id.required' => 'Device ID Wajib terisi!',
            'phone.required' => 'No WA Wajib terisi!',
            'status.required' => 'Status Wajib terisi!'
        ];


        $request->validate($rules, $messages);
        $datarow = $request->all();



        Device::create($datarow);

        return redirect('device');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        return view('pages.device.detail', [
            'data' => $device
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        return view('pages.device.edit', [
            'data' => $device,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        $rules = [
            'device_id' => 'required',
            'phone' => 'required',
            'status' => 'required'
        ];

        $messages = [
            'device_id.required' => 'Device ID Wajib terisi!',
            'phone.required' => 'No WA Wajib terisi!',
            'status.required' => 'Status Wajib terisi!'
        ];


        $request->validate($rules, $messages);
        $datarow = $request->all();



        $device->update($datarow);

        return redirect('device');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {

        $device->delete();
        return redirect('device');
    }

    public function export()
    {
        return Excel::download(new DeviceExport, 'devices.xlsx');
    }

    public function deviceCreate()
    {
        // api/getQrCode

        $setting = Setting::find(1);
        $base_url = $setting->base_url;

        $client = new Client();
        $url = $base_url .'/api/getQrCode';

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Content-Type' => 'text/html',
                    'Accept' => 'text/html'
                ],
                'verify' => false
            ]);

            if ($response->getStatusCode() == 200) {
                return $response->getBody(true);
                // dd($response->getBody());
                // return response()->json($response->getBody(), 200);
            } else {
                return response()->json(['error' => 'Gagal mengambil data dari API'], 500);
            }
        } catch (ClientException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'body' => json_decode($e->getResponse()->getBody()->getContents(), true),
                'request' => $e->getRequest(),
                'status' => $e->getResponse()->getStatusCode(),
                'url' => $url
            ]);
        }
    }
}
