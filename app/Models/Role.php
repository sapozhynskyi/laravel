<?php

namespace App\Models;

use App\Helpers\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function scopeCustomer($query){
        return $this->getRole($query);
    }
    public function scopeAdmin($query){
        return $this->getRole($query, 'Admin');
    }
    protected function getRole($query, $role = 'Customer'){
        return $query->where('name', '=', RolesEnum::findByKey(ucfirst($role))->value);
    }
}
