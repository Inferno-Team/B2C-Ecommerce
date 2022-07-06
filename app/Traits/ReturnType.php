<?php

namespace App\Traits;

trait ReturnType
{
    public function returnError($code, $msg)
    {
        return response()->json([
            'code' => $code,
            'msg' => $msg
        ]);
    }
    public function returnSuccessMessage($msg = "", $code = 200)
    {
        return response()->json([
            'code' => $code,
            'msg' => $msg
        ], 200);
    }
    public function returnData($key, $value, $msg = "", $code = 200)
    {
        return response()->json([

            'code' => $code,
            'msg' => $msg,
            $key => $value
        ]);
    }
}
