<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id', 'latitude', 'longitude', 'tag_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class, "questions_id");
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'tag_question', 'questions_id', 'tags_id');
    }
}
