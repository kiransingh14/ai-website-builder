<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBusiness;
use App\Models\Business;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusinessController extends Controller
{

    public function __construct()
    {
        Log::channel('daily')->info('AuthController initialized');
    }

    public function createBusiness(AddBusiness $request)
    {
    try
        {
           $user = auth()->id();

            $existing = Business::where('user_id', $user)
            ->where('name', $request->name)
            ->where('type', $request->type)
            ->where('description', $request->description)
            ->first()
            ->latest();

            $createBusiness = Business::createOrUpdate([
                'user_id' => $user,
                'name' => $request->name,
                'type' => $request->type
            ],[
                'name' => $request->name,
                'type' => $request->type,
                'description' => $request->description
            ]);


            return redirect('/dashboard')->with('success', 'Website request Added Successfully.');
        }catch (Exception $e) 
        {
            Log::error('Register failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $user = auth()->id();

        $businesses = Business::where('user_id', $user)
            ->leftJoin('websites', 'websites.business_id', '=', 'businesses.id')
            ->select([
                'businesses.id',
                'businesses.name',
                'businesses.type',
                'businesses.description',
                'websites.id as website_id'
            ])
            ->orderBy('businesses.id', 'desc')
            ->paginate($perPage);

        \Log::info('Businesses fetched', ['count' => $businesses->count()]);

        return view('website.dashboard', compact('businesses'));
    }
}
