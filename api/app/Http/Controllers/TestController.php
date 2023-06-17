<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Recipient;
use Illuminate\Support\Facades\DB;



class TestController extends Controller
{
    public function sendMessages(){
        $recipients = Recipient::take(100)->get();
        return $recipients;
    }
}
