<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier'  => (int)$category->id,
            'title'       => (string)$category->name,
            'description' => (string)$category->description,
            'created_at'  => (string)$category->created_at,
            'updated_at'  => (string)$category->updated_at,
            'deleted_at'  => isset($category->deleted_at) ? (string)$category->deleted_at : null
        ];
    }
}
