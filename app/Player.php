<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'players'
    ];

    public static function getPlayers($start, $n, $level = null, $search = null)
    {
        $query = static::select();
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('id', 'like', '%'.$search.'%')
                    ->orWhere('name', 'like', '%'.$search.'%')
                    ->orWhere('level', 'like', '%'.$search.'%')
                    ->orWhere('score', 'like', '%'.$search.'%');
            });
        }
        if ($level) {
            $query->where('level', 'like', '%'.$level.'%');
        }
        return [
            'total' => $query->count(),
            'players' => $query->offset($start)->limit($n)->get(),

        ];
    }

}
