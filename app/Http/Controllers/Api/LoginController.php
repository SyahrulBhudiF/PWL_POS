<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        /**
         * set validation rule for user request
         */
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        /**
         * if validation fails
         */
        if ($validator->fails()) {
            /**
             * meaning http response status code:
             *
             * 422 Unprocessable Content
             *
             * Web Distributed Authoring and Versioning (WebDAV) is an HTTP Extension that lets web developers update their content remotely from a client.
             *
             *
             * The request was well-formed but was unable to be followed due
             * to semantic errors.
             */
            return response()->json($validator->errors(), 422);
        }

        /**
         * return JSON http response when unAuthorized or auth failed
         */
        if (!$token = auth()->guard('api')->attempt($request->only('username', 'password'))) {
            return response()->json([
                /**
                 * meaning http response status:
                 *
                 * 401 Unauthorized
                 *
                 * Although the HTTP standard specifies "unauthorized",
                 * semantically this response means "unauthenticated". That
                 * is, the client must authenticate itself to get the
                 * requested response.
                 */
                'success' => false,
                'message' => 'Username atau Password Anda salah'
            ], 401);
        }

        /**
         * return JSON http response when auth success
         */
        return response()->json([
            /**
             * meaning http response status:
             *
             * 200 OK
             *
             * The request succeeded. The result meaning of "success" depends
             * on the HTTP method:
             *
             * GET: The resource has been fetched and transmitted in the
             * message body.
             *
             * HEAD: The representation headers are included in the response
             * without any message body.
             *
             * PUT or POST: The resource describing the result of the action
             * is transmitted in the message body.
             *
             * TRACE: The message body contains the request message as
             * received by the server.
             */
            'success' => true,
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }
}
