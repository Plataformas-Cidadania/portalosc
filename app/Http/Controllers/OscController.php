<?php
  
namespace App\Http\Controllers;

// use DB;

use App\Odbc\Osc;
use App\Http\Controllers\Controller;

class OscController extends Controller{
    public function getOsc($id){
    	$osc = new Osc();
        $result = $osc->getOsc($id);
        
        return $result;
    }
}