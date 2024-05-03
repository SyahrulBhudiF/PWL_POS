<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /**
         * set validation rule for user request
         */
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required'
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
         * save a new model data and return instance
         */
        $user = User::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);

        /**
         * return JSON http response when update success
         */
        if ($user) {
            return response()->json([
                /**
                 * meaning http response status:
                 *
                 * 201 Created
                 *
                 * The request succeeded, and a new resource was created as a
                 * result. This is typically the response sent after POST
                 * requests, or some PUT requests.
                 */
                'success' => true,
                'user' => $user
            ], 201);
        }

        /**
         * return JSON http response when insert failed
         */
        return response()->json([
            /**
             * meaning http response status:
             *
             * 409 Conflict
             *
             * The 409 status code is typically used when there is a conflict
             * between the request and the current state of the server. In the
             * case of creating a user, if the creation fails because of a
             * duplicate email address or a unique constraint violation, it
             * would be appropriate to return a 409 response.
             */
            'success' => false
        ], 409);
    }
}
