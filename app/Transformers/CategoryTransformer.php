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
            'deleted_at'  => isset($category->deleted_at) ? (string)$category->deleted_at : null,
            //HATEOAS
            'links'       => [
                [
                    'rel'  => 'self',
                    'href' => route('categories.show', $category->id)
                ],
                [
                    'rel'  => 'category.buyers',
                    'href' => route('categories.buyers.index', $category->id)
                ],
                [
                    'rel'  => 'category.products',
                    'href' => route('categories.products.index', $category->id)
                ],
                [
                    'rel'  => 'category.sellers',
                    'href' => route('categories.sellers.index', $category->id)
                ],
                [
                    'rel'  => 'category.transactions',
                    'href' => route('categories.transactions.index', $category->id)
                ]
            ]
        ];
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier'  => 'id',
            'title'       => 'title',
            'description' => 'description',
            'created_at'  => 'created_at',
            'updated_at'  => 'updated_at',
            'deleted_at'  => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public static function transformedAttribute($index)
    {
        $attributes =  [
            'id'          => 'identifier',
            'title'       => 'title',
            'description' => 'description',
            'created_at'  => 'created_at',
            'updated_at'  => 'updated_at',
            'deleted_at'  => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
