<?php

namespace App\Http\Controllers\Api;

use App\Model\Member;
use App\Model\Team;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allTeam()
    {
        $team = Team::orderBy('id','DESC')->where('status','!=','INACTIVO')->get();
        $myteam = Team::where('user_id',Auth::user()->id)->first();
        //$teamcount = Team::all()->count();

        return compact('teamcount','team','myteam');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTeam()
    {
        $myteam = Team::where('user_id',Auth::user()->id)->first();
        $mymembers = Member::leftJoin('users','users.id','members.user_id')->where('user_id','!=',Auth::user()->id)
            ->where('team_id',$myteam->id)
            ->where('role','MEMBER')
            ->get();
        $members = Member::leftJoin('users','users.id','members.user_id')->where('user_id','!=',Auth::user()->id)
            ->where('team_id',$myteam->id)
            ->where('role','ADMIN')
            ->get();
        return compact('myteam','mymembers','members');
    }

    public function tuTeam()
    {

        $tuteam = Member::leftJoin('teams','teams.id','members.team_id')
            ->where('teams.user_id','!=',Auth::user()->id)->first();

        $mymembers = Member::leftJoin('users','users.id','members.user_id')->where('user_id','!=',Auth::user()->id)
            ->where('team_id',$tuteam->id)
            ->where('role','MEMBER')
            ->get();
        $members = Member::leftJoin('users','users.id','members.user_id')->where('user_id','!=',Auth::user()->id)
            ->where('team_id',$tuteam->id)
            ->where('role','ADMIN')
            ->get();
        return compact('tuteam','mymembers','members','users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addTeam(Request $request)
    {
        if ($request) {
            $team = new Team();
            $team->user_id = Auth::user()->id;
            $team->name = $request->name;
            $team->description = $request->description;
            if($request->status == 'INACTIVO' || $request->status == 'ACTIVO' || $request->status == 'PAUSA')
            {
                $team->status = $request->status;
            }
            $team->slug = str_slug('Team'.' '.$request->name,'-');
            $team->save();
        }else{
            return 'false serve no tiene request';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function joinTeam(Request $request)
    {
        if ($request) {
            if($request->role){
                $member = Member::where('user_id',$request->user_id)
                ->where('team_id',$request->team_id)
                ->update(['role' => 'ADMIN']);
                return compact('member');
            }else{
                $member = new Member();
                $member->user_id = Auth::user()->id;
                $member->team_id = $request->id;
                $member->role = 'MEMBER';
                $member->save();
                return compact('member');
            }
        }else{
            return 'false serve no tiene request';
        }
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
