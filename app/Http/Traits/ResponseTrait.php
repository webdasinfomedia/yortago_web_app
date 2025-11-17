<?php

namespace App\Http\Traits;

trait ResponseTrait {

    public function returnWebResponse($result,$type){
        return back()->with('message_alert',array('result' =>$result,'class' => $type));
    }

    public function returnApiResponse($status,$message,$data){
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],$status);
    }

    public function ResponseVariables(){
        $stdVars = new \stdClass();
        $stdVars->ERROR_IMAGE_RESPONSE = "Error occurred while uploading image, We are trying to fix it.";
        $stdVars->ERROR_RESPONSE = "Regret, Something went wrong. We are trying to fix it.";
        return $stdVars;
    }

    public function returnObjectResponse($status,$data){
        $r = new \stdClass();
        $r->data = $data;
        $r->status = $status;
        return $r;
    }

    public function redirectBackWebResponse($page,$result,$type){
        return redirect()->route($page)->with('message_alert',array('result' =>$result,'class' => $type));
    }
    public function redirectBackWebResponseWithParam($page,$params,$result,$type){
        return redirect()->route($page,$params)->with('message_alert',array('result' =>$result,'class' => $type));
    }
}
