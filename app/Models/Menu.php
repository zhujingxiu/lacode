<?php

namespace App\Models;


class Menu extends Model
{
    //
    public $timestamps = FALSE;
    protected $fillable = ['role','parent_id','title','style','icon','sort','status'];

    public function parent()
    {
        return $this->belongsTo(get_class($this),'parent_id');
    }

    public function children()
    {
        return $this->hasMany(get_class($this), 'parent_id');
    }
}
