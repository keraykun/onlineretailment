<?php

namespace App\Http\Controllers\Client\Settings;

use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\Models\User;
use App\Models\userImage;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index(){
        return view('client.settings.index');
    }

    public function password(Request $request){
        $request->validate([
            'password'=>['required', new MatchOldPassword],
            'newpassword'=>'required|min:8|max:20',
            'confirmpassword' => 'required|min:8|same:newpassword'
        ]);
        User::find(auth()->user()->id)
        ->update(['password'=> Hash::make($request->newpassword)]);

        return redirect()->back()->with('success','Password has been Changed');
    }

    public function detail(Request $request){
        $test = $request->validate([
             'name'=>'required|min:8|max:20',
         ]);
         User::find(auth()
         ->user()->id)
         ->update(['name'=>$request->name]);
         $request->session()->push('name', true);
         return redirect()->back()->with('success','Name has been Changed');
     }


     public function picture(Request $request){
        $user = Auth()->user()->id;
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $imageName = time().'.'.$request->image->extension();
        if(file_exists($path = public_path('storage/users/'.$request->file('image')->getClientOriginalName()))){
            unlink($path);
            userImage::where('user_id',$user)->update(['name'=>$imageName]);
            $request->image->move(public_path('storage/users'), $imageName);
            $request->session()->push('image', true);
        }else{
            userImage::create(['user_id'=>$user,'name'=>$imageName]);
            $request->image->move(public_path('storage/users'), $imageName);
            $request->session()->push('image', true);
        }
        return redirect()->back()->with('success','Picture has been updated');
     }
}
