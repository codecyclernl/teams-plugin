<?php namespace Codecycler\Teams\Models;

use Model;
use Ramsey\Uuid\Uuid;
use System\Classes\PluginManager;
use Codecycler\Teams\Classes\TeamManager;

/**
 * Model
 */
class Team extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    protected $appends = [
        'is_active',
    ];

    protected $jsonable = [
        'theme_options',
        'properties',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'codecycler_teams_teams';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $morphedByMany = [
        'backend_users' => [
            \Backend\Models\User::class,
            'table' => 'codecycler_teams_teams_users',
            'name' => 'teamable',
            'timestamps' => true,
        ],
    ];

    public $belongsToMany = [
        'features' => [
            Feature::class,
            'table' => 'codecycler_teams_features_teams',
        ],
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Check for user plugins
        if (PluginManager::instance()->exists('RainLab.User')) {
            // Attach RainLab users to the relations
            $this->morphedByMany['users'] = [
                \RainLab\User\Models\User::class,
                'table' => 'codecycler_teams_teams_users',
                'name' => 'teamable',
                'timestamps' => true,
            ];
        }
    }

    public function beforeSave()
    {
        if (!$this->code) {
            $this->code = Uuid::uuid4();
        }
    }

    public static function byCode($code)
    {
        return static::where('code', $code);
    }

    public function getIsActiveAttribute()
    {
        $active = TeamManager::instance()->active();

        if (!$active) {
            return false;
        }

        return $active->id === $this->id;
    }

    public function theme()
    {
        $output = [];

        $fields = Settings::get('theme_options');

        foreach ($fields as $field) {
            $value = $this->theme_options[$field['key']];

            if ($field['type'] === 'mediafinder') {
                $output[$field['key']] = url('storage/app/media' . $value);
                continue;
            }

            $output[$field['key']] = $value;
        }

        return $output;
    }

    public function featureKeys()
    {
        return $this->features->pluck('feature_key')->toArray();
    }
}
