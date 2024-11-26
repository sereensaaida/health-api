<?php

namespace App\Services;

use App\Core\PasswordTrait;
use App\Core\Result;
use App\Validation\Validator;
use App\Models\AccountModel;

class AccountService
{
    use PasswordTrait;

    public function __construct(private AccountModel $account_model)
    {
        $this->account_model = $account_model;
    }

    /**
     * Service for creating a new food
     *
     * @param array $new_food The array of food information from the request body
     * @return Result Returning the result in JSON format and calling the appropriate model method
     */
    public function createUser(array $new_user): Result
    {
        //* Step 1) Using Valitron, validate the data
        $data = array(
            "first_name" => $new_user['first_name'],
            "last_name" => $new_user['last_name'],
            "email" => $new_user['email'],
            "password" => $new_user['password'],
            "role" => $new_user['role'],
        );


        //! Update the rules to meet better constraints, like password requirements.
        $rules = array(
            'user_id' => [
                'integer',
                ['min', 1]
            ],
            'first_name' => array(
                'required',
                array('lengthMin', 4)
            ),
            'last_name' => array(
                'required',
                array('lengthMin', 4)
            ),
            'email' => array(
                'required',
                array('lengthMin', 4)
            ),
            'password' => array(
                'required',
                array('lengthMin', 4)
            ),
            'role' => array(
                'required',
                array('lengthMin', 4)
            )
        );

        //* Step 2) Insert into the database
        $validator = new Validator($data, [], 'en');

        // Fix this:
        $validator->mapFieldsRules($rules);

        if ($validator->validate()) {
            //* Hashing the password if the requirements were passed on the plain password.
            $new_user['password'] = $this->cryptPassword($new_user['password']);
            $this->account_model->insertUser($new_user);
            return Result::success("User has been inserted!");
        } else {
            return Result::fail("Data not valid.");
        }
    }
}
