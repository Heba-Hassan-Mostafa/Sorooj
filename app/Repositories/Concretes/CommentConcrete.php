<?php

namespace App\Repositories\Concretes;

use App\Models\Comment;
use App\Repositories\Contracts\CommentContract;
use Illuminate\Database\Eloquent\Model;


class CommentConcrete extends BaseConcrete implements CommentContract
{
    /**
     * AdminConcrete constructor.
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $record = parent::update($model, $attributes);

        return $record;

    }
}
