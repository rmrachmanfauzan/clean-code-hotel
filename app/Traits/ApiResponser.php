<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Building success response
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data,$type="normal",$code = Response::HTTP_OK,$message="Ok")
    {
        if ($type=="pagination") {
            return \response()->json([
                'message' => $message,
                'data' => $this->mapping($data),     
            ], $code);
        }

        return \response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($message, $code)
    {
        return \response()->json([
            'message' =>$message,
            'data' => null
        ], $code);
    }

    protected function mapping($data)
    {
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $items = $data->items();
            if (isset($this->shareUrl)) {
                foreach ($items as $key => $value) {
                    $items[$key]['shareUrl'] = url() . env('PREFIX') . $this->shareUrl . $value[$this->shareUrlKey];
                }
            }

            return array(
                'currentPage'  => $data->currentPage(),
                'perPage'      => $data->perPage(),
                'total'        => $data->total(),
                'nextUrl'      => is_null($data->nextPageUrl()) ? '' : $data->nextPageUrl(),
                'previousUrl'  => is_null($data->previousPageUrl()) ? '' : $data->previousPageUrl(),
                'lastPage'     => $data->lastPage(),
                'from'         => is_null($data->firstItem()) ? 0 : $data->firstItem(),
                'to'           => is_null($data->lastItem()) ? 0 : $data->lastItem(),
                'firstPageUrl' => $data->url(0),
                'lastPageUrl'  => $data->url($data->lastPage()),
                'path'         => $data->path(),
                'items'        => $data->items(),
            );
        } else {
            return $data;
        }
    }

}