<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BusinessController extends Controller
{

    public function __construct()
    {
        Log::channel('daily');
    }

    public function createBusiness(Request $request)
    {
    try
        {
            $request->validate(
            ['name' => 'required|min:1|max:255',
            'type' => 'required|min:1|max:255',
            'description' => 'required|min:6']
            );
            $user = auth()->id();
            $userBusinesses = Business::where('user_id', $user)->whereDate('created_at', Carbon::today())->count();
            if($userBusinesses >=5){
                 return response()->json(["Today's Website Generation Using AI Limit exceeeds.Please try again in 24 hours."]);
            }
    
           $apiKey = config('app.generative_ai.api_key');
            $apiUrl =config('app.generative_ai.url');
            $url =$apiUrl.'?key='.$apiKey;
            $response = Http::post(
                $url,
                [
                    "contents"=> [
                        [   
                            "parts"=> [           [
                            "text"=> "Generate website title, tagline, about section and services for a ".$request->type." business named ".$request->name. " .Description: ". $request->description."."
                ]]]]]
            );

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
        return view('website.dashboard', compact('businesses'));
    }
}
