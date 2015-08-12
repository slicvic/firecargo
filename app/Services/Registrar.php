<?php namespace App\Services;

use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Event;

use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use App\Models\Address;
use App\Events\UserRegisteredEvent;

class Registrar implements RegistrarContract {

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        $data['registration_code'] = 'll1';
        $rules = [
            'registration_code' => 'required|exists:companies,corp_code',
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:8,20|confirmed',
            'phone' => 'required|phone',
            'mobile_phone' => 'phone',
            'address1' => 'required',
            'city' => 'required|alpha_spaces',
            'state' => 'required|alpha_spaces',
            'country_id' => 'required',
            'terms_and_conditions' => 'accepted',
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data)
    {
                $data['registration_code'] = 'll1';

        $company = Company::where('corp_code', $data['registration_code'])->first();

        // Create user and customer account (See App\Observers\UserObserver)
        $user = new User;
        $user->company_id = $company->id;
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->active = TRUE;
        $user->role_id = Role::CUSTOMER;
        $user->save();

        // Create account address
        $address = new Address;
        $address->address1 = $data['address1'];
        $address->address2 = $data['address2'];
        $address->city = $data['city'];
        $address->state = $data['state'];
        $address->postal_code = $data['postal_code'];
        $address->country_id = $data['country_id'];
        $address->save();

        // Update account
        $account = $user->account()->first();
        $account->phone = $data['phone'];
        $account->mobile_phone = $data['mobile_phone'];
        $account->shippingAddress()->associate($address);
        $account->save();

        Event::fire(new UserRegisteredEvent($user));
    }
}
