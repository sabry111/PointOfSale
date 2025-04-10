<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct()
    {

        $this->middleware(['permission:clients_read'])->only('index');
        $this->middleware(['permission:clients_create'])->only('create');
        $this->middleware(['permission:clients_update'])->only('edit','update');
        $this->middleware(['permission:clients_delete'])->only('destroy');
    }

    public function index(Request $request)
    {

        $clients = Client::when(function ($q) use ($request) {
            return $q->when($request->search, function ($q) use ($request) {
                return $q->where('name', 'like', '%' . $request->search . '%')
                    ->orwhere('phone', 'like', '%' . $request->search . '%')
                    ->orwhere('address', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(4);
        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create'); 
    }

    public function store(Request $request)
    {
        $request_data = $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'address' => 'required',
        ]);
        $request_data['phone'] = array_filter($request->phone);
        Client::create($request_data);
        return redirect(route('dashboard.clients.index'));
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request_data = $request->validate([
            'name' => 'required',
            'phone' => 'required|array|min:1',
            'address' => 'required',
        ]);
        $request_data['phone'] = array_filter($request->phone);
        $client->update($request_data);
        return redirect(route('dashboard.clients.index'));
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect(route('dashboard.clients.index'));
    }
}
