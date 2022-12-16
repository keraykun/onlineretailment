<?php

namespace App\Http\Controllers\Admin\Users;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usersState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $search = $request->search;
            $users = User::whereHas('role',function($role) use($search){
                return $role->where('name','like', "%$search%")
                ->whereNotIn('name',['admin']);
            })->orWhereHas('state',function($state) use($search){
                return $state->where('status','like', "%$search%");
            })
            ->orWhere('name','like', "%$search%")
            ->with('role','state')->paginate(10);
        }else{
            $users = User::whereHas('role',function($role){
            return $role->whereNotIn('name',['admin']);
        })->with('role','state')->paginate(10);
        }
        return view('admin.users.index',['users'=>$users]);
    }

    public function status(Request $status){
       usersState::where('user_id',$status->id)->update(['status'=>$status->estate]);
       return redirect()->back();
    }

    public function show(User $user){
          $user = User::where('_id',$user->id)
         ->with([
            'role',
            'products',
            'productsold'=>function($sold) use($user){
            $sold->where('user_id',$user->id);
            },
            'orders'=>function($order) use($user){
                $order->where('user_id',$user->id);
            },
            'wishlist'=>function($wishlist) use($user){
                $wishlist->where('user_id',$user->id);
            },
            'orderstatus'=>function($sold) use($user){
                $sold->where('user_id',$user->id);
            },
            'violations'
            ])->first();
        return view('admin.users.show',['user'=>$user]);
    }
}
