<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\UserCredential;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('room-{roomId}', function ( UserCredential $user, $roomId) { 
    if($user->canJoinRoom($roomId))
        return ['id' => $user->user_id, 'name' => $user->username, 'ably-capability' => ["subscribe", "history", "channel-metadata", "presence", "publish"]];

    return false;
});

