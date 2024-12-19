<?php

namespace App\Traits;

trait HasApiResponse
{
    public function success($message,$data,$code=200)
    {
        return response()->json(
            [
                'status'=>true,
                'message'=>$message,
                'data'=>$data
            ],$code
        );
    }

    public function error($message,$code)
    {
        return response()->json(
            [
                'status'=>false,
                'message'=>$message,
            ],$code
        );
    }
}
