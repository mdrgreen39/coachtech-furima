<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'sold_item', 'item_id', 'user_id')
        ->withTimestamps();
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }


    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function soldItems()
    {
        return $this->hasMany(SoldItem::class, 'item_id', 'id');
    }

    public function buyers()
    {
        // アイテムを購入したユーザー（中間テーブルを通して多対多）
        return $this->hasManyThrough(User::class, SoldItem::class);
    }

    public function isSold()
    {
        return $this->soldItems()->exists();
    }

}
