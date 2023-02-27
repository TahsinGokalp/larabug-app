<?php

namespace App\Traits;

use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;

/**
 * Captcha Trait
 *
 * @param $time
 * @param $tz
 * @return bool
 *
 * @version 1.0
 *
 * @author Dennis Smink
 *
 * @website http://www.dennissmink.nl
 *
 * @date 07-11-2016
 */
trait Captcha
{
    public function captchaCheck(Request $request)
    {
        $response = $request->input('g-recaptcha-response');
        $remoteip = $request->ip();
        $secret = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);

        if ($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }
    }
}
