<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Website;
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
                return redirect('/dashboard')->with('failed',"Today's Website Generation Using AI Limit exceeeds.Please try again in 24 hours.");
            }

            $createBusiness= Business::create([
                "user_id" => $user,
                "name" => $request->name,
                "type" => $request->type,
                "description" => $request->description
            ]);
    
           $apiKey = config('app.generative_ai.api_key');
            $apiUrl =config('app.generative_ai.url');
            $url =$apiUrl.'?key='.$apiKey;
            $response = Http::post(
                $url,
                [
                    "contents" => 
                    [
                        [
                            "parts" =>
                            [
                                [
                                    "text" => "Generate a response in STRICT JSON format only (no explanation, no markdown, no extra text).

                                    Business Details:
                                    - Type: {$request->type}
                                    - Name: {$request->name}
                                    - Description: {$request->description}

                                    Return JSON with the following keys:
                                    {
                                    \"title\": \"\",
                                    \"tagline\": \"\",
                                    \"about\": \"\",
                                    \"services\": [\"\", \"\", \"\"],
                                    \"html\": \"\"
                                    }

                                    Instructions:
                                    1. Fill all fields properly based on the business details.
                                    2. 'services' must contain 3 to 5 items.
                                    3. 'html' must contain a complete, clean, modern website homepage in valid HTML.

                                    HTML Requirements:
                                    - Use proper HTML5 structure (<html>, <head>, <body>)
                                    - Include:
                                    • Title inside <title>
                                    • Hero section (business name + tagline)
                                    • About section
                                    • Services section
                                    - Use simple inline CSS for styling
                                    - Keep it clean and professional
                                    - Do NOT include <script> tags
                                    - Do NOT include explanations or comments

                                    IMPORTANT:
                                    - Return ONLY valid JSON
                                    - Escape all quotes inside HTML properly
                                    - Ensure the JSON is parseable"
                                ]
                            ]
                        ]
                    ]
                ]
            );
            $response = json_decode($response, true);
          
            if(isset($response['candidates']) &&
                isset($response['candidates'][0]) &&
                isset($response['candidates'][0]['content']) && 
                isset($response['candidates'][0]['content']['parts']) &&
                isset($response['candidates'][0]['content']['parts'][0]) &&
                isset($response['candidates'][0]['content']['parts'][0]['text']) )
            {
                $text = json_decode($response['candidates'][0]['content']['parts'][0]['text'], true);
                Website::create(
                    [
                        'business_id'=>$createBusiness->id,
                        'website_title'=>$text['title'],
                        'tagline'=>$text['tagline'],
                        'about_section'=>$text['about'],
                        'services'=>json_encode([$text['services']]),
                        'slug'=>$text['html'],
                        'status'=>"published"
                    ]
                );
                $createBusiness->status="success";
                $createBusiness->save();
            }else{
                  $createBusiness->status="failed";
                $createBusiness->save();
            }
            return redirect('/dashboard')->with('success', 'Website request Added Successfully.');
        }catch (Exception $e) 
        {
            Log::error('Register failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect('/dashboard')->with('failed', 'Time Out.');
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
                'businesses.status',
                'websites.id as website_id'
            ])
            ->orderBy('businesses.id', 'desc')
            ->paginate($perPage);
        return view('website.dashboard', compact('businesses'));
    }

    public function getWebsite($id)
    {
        $website = Website::find($id);

        if (!$website) {
            return response()->json(['message' => 'Website not found'], 404);
        }

        return response($website->slug)
                ->header('Content-Type', 'text/html');
    }


    public function downloadWebContent($id)
    {
         $website = Website::find($id);

        if (!$website) {
            return response()->json(['message' => 'Website not found'], 404);
        }
        $fileName = strtolower(str_replace(' ', '_',$website->website_title)).'.html';

        return response($website->slug)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');

    }

    public function deleteBusiness($id)
    {
        $business =Business::find($id);
        if(!$business)
        {
            return redirect('/dashboard')->with('failed','Deleted failed');
        }
        Website::where('business_id', $id)->delete();
        $business->delete();
        return redirect('/dashboard')->with('success','Deleted successfully');
    }
}
