<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Junges\Kafka\Facades\Kafka;

class TrackingController extends Controller {

    public function page_naviation_event(Request $request){
        Kafka::publish()
            ->onTopic('page_navigation_events')
            ->withBodyKey('user_id', auth()->id())
            ->withBodyKey('prev_url', $request->input('prev_url', ''))
            ->withBodyKey('new_url', $request->input('new_url', ''))
            ->withBodyKey('navigated_at', now()->toDateTimeString())
            ->send();

        return response()->noContent();
    }

}