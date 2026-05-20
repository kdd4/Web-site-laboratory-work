<?php

namespace App\Http\Controllers;

use App\Models\blogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class BlogCommentController extends Controller
{
    public function index(Request $request, string $id)
    {
        $comments = blogComment::where('blogID', $id)->get();

        $commentsWithFIO = $comments->map(function(blogComment $comment, int $key) {
            $id = $comment->userID;

            $result = $comment->toArray();

            $result['fio'] = '1';
            if ($id !== null) {
                $user = DB::table('user')->find($id);
                $result['fio'] = '2';

                if ($user === null) return $result;

                $result['fio'] = $user->fio;
            }

            return $result;
        });

        return response()->json(
            $commentsWithFIO->toArray()
            );
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'blogID' => ['required', 'integer'],
            'text'   => ['required', 'string', 'min:1'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false, 'error' => implode(', ', $validator->errors()->all()), 
                ], 400);
        }

        $comment = new blogComment;

        $comment->blogID = $request->input('blogID');
        $comment->text = $request->input('text');
        $comment->time = date('Y-m-d H:i:s');

        $token = $request->cookie('JWT');
        try {
            $payload = JWTAuth::setToken($token)->getPayload();
            $userID = $payload->get('sub');

            $comment->userID = $userID;
        } catch (TokenExpiredException $e) {
            return response()->json(['result' => false, 'error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['result' => false, 'error' => 'Token invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['result' => false, 'error' => 'Token missing'], 401);
        }

        $result = $comment->save();


        return response()->json([
            'result' => $result
        ], $result ? 200 : 500);
    }
}
