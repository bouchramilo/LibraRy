<?php
namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    // *******************************************************************************************************************************
    public function index()
    {
        $users = User::where("id", "!=", Auth::id())->paginate(10);
        return view('Librarian.users', ['users' => $users]);
    }

    // public function index()
    // {
    //     $response = new StreamedResponse(function () {
    //         $lastSentTime = null;
    //         $sentUserIds = [];

    //         while (true) {
    //             try {
    //                 // Get only new or updated users since last check
    //                 $query = User::where('id', '!=', Auth::id())
    //                     ->orderBy('updated_at', 'desc');

    //                 if ($lastSentTime) {
    //                     $query->where('updated_at', '>', $lastSentTime);
    //                 }

    //                 $users = $query->get();

    //                 if ($users->isNotEmpty()) {
    //                     foreach ($users as $user) {
    //                         // Skip if we've already sent this user in this session
    //                         if (in_array($user->id, $sentUserIds)) {
    //                             continue;
    //                         }

    //                         $data = [
    //                             'user_id' => $user->id,
    //                             'first_name' => $user->first_name,
    //                             'last_name' => $user->last_name,
    //                             'role' => $user->role,
    //                             'status' => $user->status,
    //                             'email' => $user->email,
    //                             'timestamp' => $user->updated_at->toDateTimeString(),
    //                         ];

    //                         echo "data: " . json_encode($data) . "\n\n";
    //                         ob_flush();
    //                         flush();

    //                         $sentUserIds[] = $user->id;
    //                     }

    //                     $lastSentTime = now();
    //                 }

    //                 // Clear sent users array periodically to prevent memory issues
    //                 if (count($sentUserIds) > 100) {
    //                     $sentUserIds = [];
    //                 }

    //                 // Wait before checking again
    //                 sleep(2);

    //             } catch (\Exception $e) {
    //                 // Log error and continue
    //                 error_log('SSE Error: ' . $e->getMessage());
    //                 sleep(5); // Wait longer if error occurs
    //             }
    //         }
    //     });

    //     $response->headers->set('Content-Type', 'text/event-stream');
    //     $response->headers->set('Cache-Control', 'no-cache');
    //     $response->headers->set('Connection', 'keep-alive');
    //     $response->headers->set('X-Accel-Buffering', 'no');

    //     return $response;
    // }

    // *******************************************************************************************************************************
    // *******************************************************************************************************************************
    public function destroy(string $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        return back()->with("success", "Vous avez supprimer le client avec success.");
    }
}
