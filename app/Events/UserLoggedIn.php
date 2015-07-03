<?php namespace App\Events;

use App\Events\Event;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class UserLoggedIn extends Event {

	use SerializesModels;

	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}
}
