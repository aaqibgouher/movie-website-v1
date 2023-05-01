<?php

namespace App\Models;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFavouriteModel extends Model
{
    protected $table = "user_favourites";

    public function user() {
        return $this -> belongsTo(UserModel::class, "user_id");
    }
}
