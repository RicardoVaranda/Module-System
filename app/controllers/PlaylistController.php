<?php
class PlaylistController extends BaseController{

	public function savePlaylist(){
		if(Request::ajax()){

		  $order = json_decode(stripslashes($_POST['order']));
		  $position = 1;

		  foreach ($order as $o) {
		  	$currSong = Song::find($o);
		  	$currSong->position = $position;
		  	$position++;
		  	$currSong->save();
		  }
		}
	}

	public function updatePlaylist(){
      	$user = User::find(Auth::user()->id);

      	if($user){
        // checks if user is logged in
        $playlist = Playlist::find($user->id)->songs;
        return View::make('account.playlist')->with('playlist', $playlist);
      } 
      else 
      {
        return Redirect::route('home')
				->with('global', 'You need to sign in first.');
      }
	}

	public function addToPlaylist(){
		if(Request::ajax()){

		  $url = Input::get('url');
		  $name = Input::get('title');
		  $img = Input::get('img');

		  $user = User::find(Auth::user()->id);

		  if($user){
		  	$id = $user->id;

		  	$id = $user->id;
		  	$pos = intval(Playlist::find(1)->songs->count());
		  	$pos++;
			$song = Song::create(array(
					'songname' => $name,
					'songurl' => $url,
					'songimg' => $img,
					'playlistid' => $id,
					'position' => $pos
			));
		}

		}
	}
}