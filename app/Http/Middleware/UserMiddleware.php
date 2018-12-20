public function getAuthUser(Request $request) {
        try {

            if (!$user = JWTAuth::toUser($request->token)) {
                return response()->json(['code' => 404, 'message' => 'user_not_found']);
            } else {

                $user = JWTAuth::toUser($request->token);
                return response()->json(['code' => 200, 'data' => ['user' => $user]]);
            }
        } catch (Exception $e) {

            return response()->json(['code' => 404, 'message' => 'Something went wrong']);

        }
    }