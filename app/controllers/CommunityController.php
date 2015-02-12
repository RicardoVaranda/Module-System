<?php
class CommunityController extends BaseController{

// How to delete first person in queue
//DELETE FROM `djqueue` WHERE `communityid` = 1 Limit 1

//How to add a person to a community
//UPDATE `users` Set `community` = 1 where `id` = 1

	public function joinCommunity($name){
		//get id of community

		$user = User::find(Auth::user()->id);
		$community = Community::where('communityname', '=', $name);

		if($user){
			$people = array();
			$people = json_decode($community->people);

			$user->community = $community->communityid;
			array_push($people, array("userid" => $user->id));

			json_encode($people);
			$community->people = $people;
			$community->save();
		}
	}

	public function queueUser($name){
		$user = User::find(Auth::user()->id);
		$community = Community::where('communityname', '=', $name);

		if($user){
			//find out if there is other people in the queue
			if($community->queue->size > 0){
				//check if the queue is less than 50
				if($community->queue->size < 50){
					$people = array();
					$people = json_decode($community->queue->people);

					$user->community = $community->communityid;
					array_push($people, array("userid" => $user->id));
				}
			} elseif ($community->queue->size == 0) {
				// Start the song straight away.
			} 			
		}
	}
	public function nextSong($name){
		sleep(400);
		$stack = array("orange", "banana", "apple", "raspberry");
		$fruit = array_shift($stack); //Pointless setting it
		print_r($stack);
	}

	public function unqueue($id){
		for ($i=0; $i <count($array) ; $i++) { 
			if($array[i]->userid == $id){
				unset($array[i]);
			}
		}
	}

}