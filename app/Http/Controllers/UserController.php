<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the list of users
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Add a new user
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create($request->all());

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Show the specified user
     *
     * @param  int  $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($user, 200);
    }

    /**
     * Update the specified user
     *
     * @param  Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->fill($request->all());

        // Check if any changes were made
        if ($user->isDirty()) {
            $user->save();
            return response()->json($user, 200);
        } else {
            return response()->json(['error' => 'At least one value must change'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified user
     *
     * @param  int  $id
     * @return Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}