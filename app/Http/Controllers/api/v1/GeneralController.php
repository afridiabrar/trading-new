<?php

namespace App\Http\Controllers\api\v1;

use App\Model\Country;
use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
// use App\Mail\MyTestMail;
// use App\Mail\MyDemoMail;
use App\Model\Ad;
use App\Model\Blog;
use App\Model\BusinessSetting;
use App\Model\Contact;
use App\Model\HelpTopic;
use App\Model\Product;
use App\Model\SocialMedia;
use App\Model\Newsletter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Log;

// use App\Http\Controllers\EmailController;

use Redirect;
// use App\Mail\MailNotify;
use App\Mail\MyDemoMail;
use App\Mail\MyTestMail;

// use Exception;
// use Mail;

class GeneralController extends Controller
{
    public function faq()
    {
        try {
            //            return response()->json(HelpTopic::orderBy('ranking')->get(),200);
            return $this->respond(['faqs' => HelpTopic::orderBy('ranking')->get()], [], 200);
        } catch (\Exception $e) {
            return $this->respond([], [], 500, $e->getMessage());
            //            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function contactUs(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string|required|alpha|max:255',
                'email' => 'required|email|max:80|regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
                'mobile_number' => 'required|numeric',
                'subject' => 'string|required|max:255',
                'message' => 'required',
            ], [
                'email.regex' => 'Please provide a valid email',
            ]);

            if ($validator->fails()) {
                return $this->respond([], Helpers::error_processor($validator), 403, 'validation error');
            }
            //return $request->all();

            $contact = Contact::create([
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "mobile_number" => $request->input('mobile_number'),
                "subject" => $request->input('subject'),
                "message" => $request->input('message'),
            ]);

            $p = $request->all();
            $p += ['mail_title' => 'This is Contact Us form mail from Trading.com'];

            $this->sendEmail($p);
            exit();
            return $this->respond(['contact' => $contact], [], 200, 'Message Send Successfully!');
        } catch (\Exception $e) {
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function sendEmail($p)
    {
        $user = auth()->user();
        $user = 'developer197855@gmail.com';
        try {
            Mail::to($user)->send(new MyTestMail($p));
        } catch (Exception $ex) {
            dd($ex);
            return $this->markdown('emails.contact.contact-form')->from('example@test.in', 'Example');
        }
    }

    public function socialMediaLinks()
    {
        try {
            $socialMedia = SocialMedia::all();
            return $this->respond(['social' => $socialMedia], [], 200, 'Message Send Successfully!');
        } catch (\Exception $e) {
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function webConfig()
    {
        try {
            $company_name = BusinessSetting::where('type', 'company_name')->first();
            $company_email = BusinessSetting::where('type', 'company_email')->first();
            $company_phone = BusinessSetting::where('type', 'company_phone')->first();
            $contact = array(
                'name' => $company_name,
                'email' => $company_email,
                'phone' => $company_phone,
            );
            return $this->respond(['contact' => $contact], [], 200, 'Retrieved Successfully!');
        } catch (\Exception $e) {

            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function newsletter(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:newsletters,email|max:80|regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            ], [
                'email.regex' => 'Please provide a valid email',
            ]);

            if ($validator->fails()) {
                return $this->respond([], Helpers::error_processor($validator), 403, 'validation error');
            }

            DB::beginTransaction();
            //            $check = Newsletter::where('email',$request->input('email'))->first();
            //            if(!empty($check)){
            //                return $this->respond([],[[]],403,'validation error');
            //            }
            //            return redirect()->back()->with('warning','Already Join Newsletter!!');

            $news = Newsletter::create([
                'email' => $request->input('email')
            ]);
            DB::commit();
            return $this->respond(['newsletter' => $news], [], 200, 'Join Newsletter Successfully!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function getAds()
    {
        try {
            $Ads = Ad::where('status', 1)->get();
            return $this->respond(['ads' => $Ads], [], 200, 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function getCountries()
    {
        try {
            $country = Country::all();
            return $this->respond(['country' => $country], [], 200, 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function blogs()
    {
        try {
            $Ads = Blog::where('published', 1)->paginate(6);
            return $this->respond(['blogs' => $Ads], [], 200, 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function blog($id)
    {
        try {
            $Ads = Blog::where('published', 1)->where('id', $id)->get();
            return $this->respond(['blog' => $Ads], [], 200, 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function topproducts()
    {
        try {
            $topproducts = Product::inRandomOrder()->limit(10)->get();
            return $this->respond(['topproducts' => $topproducts], [], 200, 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond([], [], 500, $e->getMessage());
        }
    }

    public function get_pages(Request $request)
    {

        try {
            if ($request['type'] == 'Terms And Conditions') {
                $pages = BusinessSetting::where('type', 'terms_and_conditions')->first();
            } elseif ($request['type'] == 'Privacy Policy') {
                $pages = BusinessSetting::where('type', 'privacy_policy')->first();
            } elseif ($request['type'] == 'Refund Policy') {
                $pages = BusinessSetting::where('type', 'refund_policy')->first();
            } elseif ($request['type'] == 'Cookie Policy') {
                $pages = BusinessSetting::where('type', 'cookie_policy')->first();
            }
            return $this->respond(['pages' => $pages], [], 200, 'success');
        } catch (\Exception $e) {
        }

        return response()->json($pages, 200);
    }
}
