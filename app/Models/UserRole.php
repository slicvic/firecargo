<?php namespace App\Models;

class UserRole extends BaseModel {
    protected $table = 'user_roles';

    /*public static function attachRoles($user_id, array $role_ids = array()) {
        self::detachRoles($user_id);

        $data = array();

        foreach ($role_ids as $role_id) {
            $data[] = array('user_id' => $user_id, 'role_id' => $role_id);
        }

        DB::table('users')->insert($data);
    }

    public static function detachRoles($user_id, array $role_ids = array()) {
        if ( ! count($role_ids)) {
            // Delele all the roles assigned to this user.
            return DB::table('user_roles')->where('user_id', '=', $user_id)->delete();
        }

        return DB::table('user_roles')
            ->where('user_id', '=', $user_id)
            ->whereIn('role_id', $role_ids)
            ->delete();
    }*/
}
