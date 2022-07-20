<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function showStates($id)
    {
        $states=State::orderBy('name')
        ->where('country_id',$id);

        //Get the html view

        $html=view('ajax.options')->with([
            'first_option'=>"SELEC STATE",
            'options'=>$states->get()])->render();

        

        return response()->json([
            'count'=>$states->get()->count(),
            'html'=>$html
        ]);
    }

    public function showCities($id_contry,$id_state)
    {
        $cities=City::orderBy('name')
        ->where('country_id',$id_contry);

        if($id_state>0)
        {
            $cities->where('state_id',$id_state);
        }

        

        return view('ajax.options')->with([
            'first_option'=>"SELEC CITY",
            'options'=>$cities->get()]);

    }
}
