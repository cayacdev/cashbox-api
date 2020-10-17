<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;

/**
 * App\CashBoxBudgetPlanEntry
 *
 * @property int $id
 * @property int $user_id
 * @property int $cash_box_budget_plan_id
 * @property string $date
 * @property float $value
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CashBoxBudgetPlanEntry newModelQuery()
 * @method static Builder|CashBoxBudgetPlanEntry newQuery()
 * @method static Builder|CashBoxBudgetPlanEntry query()
 * @method static Builder|CashBoxBudgetPlanEntry whereCashBoxBudgetPlanId($value)
 * @method static Builder|CashBoxBudgetPlanEntry whereCreatedAt($value)
 * @method static Builder|CashBoxBudgetPlanEntry whereDate($value)
 * @method static Builder|CashBoxBudgetPlanEntry whereDescription($value)
 * @method static Builder|CashBoxBudgetPlanEntry whereId($value)
 * @method static Builder|CashBoxBudgetPlanEntry whereUpdatedAt($value)
 * @method static Builder|CashBoxBudgetPlanEntry whereUserId($value)
 * @method static Builder|CashBoxBudgetPlanEntry whereValue($value)
 * @property-read \App\Models\CashBoxBudgetPlan $budgetPlan
 * @property-read \App\Models\CashBox|null $cashBox
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class CashBoxBudgetPlanEntry extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id', 'date', 'value', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return BelongsTo
     */
    public function budgetPlan()
    {
        return $this->belongsTo('App\Models\CashBoxBudgetPlan', 'cash_box_budget_plan_id');
    }

    /**
     * @return HasOneThrough
     */
    public function cashBox()
    {
        return $this->hasOneThrough('App\Models\CashBox', 'App\Models\CashBoxBudgetPlan');
    }
}
