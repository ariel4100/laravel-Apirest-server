<?php

namespace App\Http\Controllers\Api;

use App\Model\Friendship;
use App\Traits\Friendable;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addFriend(Request $request)
    {
        $friendship = Friendship::create([
           'requester' => Auth::user()->id,
            'user_requested' => $request->id,
            'status' => 0
        ]);
        if($friendship)
        {
            return 'solicitud enviada';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allFriend()
    {
        //$allusers = User::join('profiles','users.id','=','profiles.user_id')
            //->where('requester',Auth::user()->id)
           // ->select('users.*', 'profiles.about', 'profiles.image')
            //->where('user_requested','!=',Auth::user()->id)
            //->leftJoin('friendships','users.id','=','friendships.requester')}
            //->get();

        //leftJoin('friendships','users.id','=','friendships.requester')
        $users = User::leftJoin('friendships','users.id','friendships.requester')
            ->where('users.id','!=',Auth::user()->id)
            //->where('status','=',0)
            //->where('status',0)
            ->select('users.*','friendships.status','friendships.requester','friendships.user_requested')
            ->get();
        //->where('user_requested')

        $pendiente = Friendship::leftJoin('users','users.id','friendships.user_requested')
            ->where('requester',Auth::user()->id)
            ->where('status',0)
            //->select('users.*','friendships.requester','friendships.user_requested')
            ->get();

        $confirmar = Friendship::leftJoin('users','users.id','friendships.requester')
            ->where('user_requested',Auth::user()->id)
            ->where('status',0)
            //->select('users.*','friendships.requester','friendships.user_requested')
            ->get();
        $f1 = Friendship::leftJoin('users','users.id','friendships.requester')
            ->where('user_requested',Auth::user()->id)
            ->where('status',1)
            //->select('users.*','friendships.requester','friendships.user_requested')
            ->get();
        $f2 = Friendship::leftJoin('users','users.id','friendships.user_requested')
            ->where('requester',Auth::user()->id)
            ->where('status',1)
            //->select('users.*','friendships.requester','friendships.user_requested')
            ->get();


        $amigo = $f1->merge($f2); //array_merge($f1,$f2);

        return compact('users','pendiente','confirmar','amigo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function friend(Request $request)
    {
        $friend = Friendship::where('user_requested',Auth::user()->id)
        ->where('requester',$request->id)
        ->update(['status' => 1]);

        return $friend;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
