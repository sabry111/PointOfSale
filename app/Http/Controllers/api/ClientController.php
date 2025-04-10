<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:clients_read'])->only('index');
        $this->middleware(['permission:clients_update'])->only('update');
        $this->middleware(['permission:clients_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $clients = Client::when(function ($q) use ($request) {
        //     return $q->when($request->search, function ($q) use ($request) {
        //         return $q->where('name', 'like', '%' . $request->search . '%')
        //             ->orwhere('phone', 'like', '%' . $request->search . '%')
        //             ->orwhere('address', 'like', '%' . $request->search . '%');
        //     });
        // })->latest()->paginate(5);
        // $clientscollection = ClientCollection::make($clients);
        // return response()->json(['data' => $clientscollection, 'error' => ''], 200);


        $clients = Client::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5);
        $clientsCollection = ClientCollection::make($clients);
        return response()->json([
            'success' => true,
            'data' => $clientsCollection,
            'message' => 'Clients fetched successfully.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request_data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|array|min:1',
            'address' => 'required|string|max:500',
        ]);
        // تصفية الأرقام الفارغة داخل مصفوفة الهاتف
        $request_data['phone'] = array_filter($request->phone);
        //  إنشاء سجل جديد في قاعدة البيانات باستخدام البيانات التي تم التحقق من صحتها
        $client = Client::create($request_data);
        // إرجاع استجابة JSON
        return response()->json([
            'success' => true,
            'data' => $client,
            'message' => 'Client created successfully.',
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        // التحقق من صحة البيانات
        $request_data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|array|min:1',
            'address' => 'required|string|max:500',
        ]);
        // تصفية الأرقام الفارغة داخل مصفوفة الهاتف
        $request_data['phone'] = array_filter($request->phone);
        // تحديث بيانات العميل
        $client->update($request_data);
        // تحويل العميل إلى Collection
        $clientresource = ClientResource::make($client);
        // إرجاع استجابة JSON
        return response()->json([
            'data' => $clientresource,
            'error' => '',
            'message' => 'Client updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        // حذف العميل
        $client->delete();
        // إرجاع استجابة JSON تؤكد الحذف
        return response()->json([
            'data' => null,
            'message' => 'Client deleted successfully.',
            'error' => ''
        ], 200);
    }
}
