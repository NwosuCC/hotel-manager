<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Model extends Eloquent
{
  use SoftDeletes;

  /** Auto-updates created_at and updated_at */
  public $timestamps = true;

  protected $guarded = [];

  /**
   * The attributes that should be mutated to dates.
   * @var array
   */
  protected $dates = [
    'deleted_at', 'deadline', 'interview_date'
  ];

  // Sets overall DateTime format
//  protected $dateFormat = 'D, M j, Y';

  protected $hidden = [
    'updated_at', 'deleted_at'
  ];


  /** @return static */
  public static function instance()
  {
    return app()->make(static::class);
  }


  /**
   * See function qs() in \App\Helpers\Helpers.php
   * @param         $query
   * @return  \Illuminate\Database\Eloquent\Builder
   */
  protected function qs($query)
  {
    return qs($query);
  }


  /**
   * Returns the model keyName and its qualifiedKeyName
   * @param   $param  [Model $model | Builder $query]
   * @return  array
   */
  public static function keyNames($param)
  {
    /** @var Model $model */
    $model = ($param instanceof Builder) ? $param->getModel() : $param;

    return [$model->getQualifiedKeyName(), $model->getKeyName()];
  }

}
