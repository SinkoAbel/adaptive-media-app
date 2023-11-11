<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Todo",
 *     title="Todo item",
 * 	   @OA\Property(
 * 	        property="name",
 * 		    type="string"
 * 	   ),
 * 	   @OA\Property(
 * 		   property="description",
 * 		   type="string"
 * 	   ),
*      @OA\Property(
 *         property="completed",
 *         type="boolean"
 *     )
 * )
 */

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'completed',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


}
