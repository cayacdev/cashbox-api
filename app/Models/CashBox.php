<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class CashBox
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|CashBoxBudgetPlan[] $budgetPlans
 * @property-read int|null $budget_plans_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|CashBox newModelQuery()
 * @method static Builder|CashBox newQuery()
 * @method static Builder|CashBox query()
 * @method static Builder|CashBox whereCreatedAt($value)
 * @method static Builder|CashBox whereDescription($value)
 * @method static Builder|CashBox whereId($value)
 * @method static Builder|CashBox whereName($value)
 * @method static Builder|CashBox whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CashBox extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id', 'name', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * @return HasMany
     */
    public function budgetPlans()
    {
        return $this->hasMany('App\Models\CashBoxBudgetPlan');
    }

    /**
     * @return HasMany
     */
    public function getActivePlan()
    {
        $plans = $this->budgetPlans();
        return $plans->where(function ($query) {
            $now = DB::raw('CURDATE()');
            $query
                ->where('start_date', '<=', $now)
                ->where('end_date', '>=', $now);

        });
    }
}
