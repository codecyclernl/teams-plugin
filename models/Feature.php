<?php namespace Codecycler\Teams\Models;

use Model;

/**
 * Model
 */
class Feature extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'codecycler_teams_features';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
