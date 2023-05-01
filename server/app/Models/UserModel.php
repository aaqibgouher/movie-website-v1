<?php

namespace App\Models;

use App\Models\UserTokenModel;
use App\Models\UserFavouriteModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserModel extends Model
{
    protected $table = "users";
    protected $hidden = ["password"];

    public function tokens() {
        return $this -> hasMany(UserTokenModel::class, "user_id");
    }

    public function favourites() {
        return $this -> hasMany(UserFavouriteModel::class, "user_id");
    }
}
