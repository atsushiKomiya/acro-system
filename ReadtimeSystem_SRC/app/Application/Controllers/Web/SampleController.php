<?php

namespace App\Application\Controllers\Web;

use App\Application\Requests\SampleRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SampleController extends BaseController
{
    public function index(Request $request)
    {
        $result = ['test' => 'テスト'];

        return view('sample', $result);
    }

    public function test(SampleRequest $request)
    {
        $result = ['test' => $request->test];

        return view('sample', $result);
    }
}
