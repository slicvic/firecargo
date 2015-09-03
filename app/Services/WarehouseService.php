<?php

namespace App\Services;

use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Event;

use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use App\Models\Address;

class WarehouseService implements RegistrarContract {

    /**
     * Get a validator for an incoming warehouse create/update request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        $rules = [
            'shipper_name'  => Account::$rules['name'],
            'customer_name' => Account::$rules['name'],
            'carrier_name'  => Carrier::$rules['name']
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create a new warehouse instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $data)
    {
        $input = $request->only('warehouse', 'packages');

        $rules = [
            'shipper_name'  => Account::$rules['name'],
            'customer_name' => Account::$rules['name'],
            'carrier_name'  => Carrier::$rules['name']
        ];

        // Validate input
        $validator = Validator::make($input['warehouse'], $rules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
        }

        // Create new carrier if no carrier ID provided
        if (empty($input['warehouse']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['warehouse']['carrier_name']]);

            $input['warehouse']['carrier_id'] = $carrier->id;
        }

        // Create new shipper if no shipper ID provided
        if (empty($input['warehouse']['shipper_account_id']))
        {
            $account = Account::firstOrNew([
                'name'       => trim($input['warehouse']['shipper_name']),
                'company_id' => $this->user->company_id
            ]);

            if ( ! $account->exists)
            {
                $account->save();
                $account->tags()->attach(AccountTag::SHIPPER);
            }

            $input['warehouse']['shipper_account_id'] = $account->id;
        }

        // Create new customer account if no account ID provided
        if (empty($input['warehouse']['customer_account_id']))
        {
            $account = Account::create([
                'name'       => $input['warehouse']['customer_name'],
                'company_id' => $this->user->company_id
            ]);

            $account->tags()->attach(AccountTag::CUSTOMER);

            $input['warehouse']['customer_account_id'] = $account->id;
        }

        // Save warehouse
        $warehouse->shipper_account_id = $input['warehouse']['shipper_account_id'];
        $warehouse->customer_account_id = $input['warehouse']['customer_account_id'];
        $warehouse->carrier_id = $input['warehouse']['carrier_id'];
        $warehouse->notes = $input['warehouse']['notes'];
        $warehouse->save();

        // Save packages
        if ($input['packages'])
        {
            $warehouse->createOrUpdatePackages($input['packages']);
        }
    }
}
