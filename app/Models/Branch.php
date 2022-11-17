<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        //'name' => 'json',
        'additional_ips' => 'array',
        //'working_days' => 'json',
    ];

    public static $DAYS = [
        'Sat' => 'Saturday' ,
        'Sun' => 'Sunday' ,
        'Mon' => 'Monday' ,
        'Tus' => 'Tuesday' ,
        'Wed' => 'Wednesday' ,
        'Thu' => 'Thursday' ,
        'Fri' => 'Friday' ,
    ];

    public function getWorkingDaysAttribute() {
        return DB::table('working_days')->where('branch_id', $this->id)->pluck('day')->toArray();
    }

    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branchLevel()
    {
        return $this->belongsTo(BranchLevel::class);
    }

    public function lineType()
    {
        return $this->belongsTo(LineType::class);
    }

    public function router()
    {
        return $this->belongsTo(Router::class);
    }



    public function lineCapacity(){
        return $this->belongsTo(LineCapacitie::class);
    }



    public function routerName(){
        return $this->belongsTo(Router::class, 'router_model_id' );
    }

    public function upsInstallation(){
        return $this->belongsTo(UpsInstallation::class,'ups_installation_id');
    }

    public function model(){
        return $this->belongsTo(SwitchModel::class , 'switch_model_id');
    }

    public function entutiyStatus(){
        return $this->belongsTo(EntuityStatus::class , 'entuity_status_id');
    }

    public function government(){
        return $this->belongsTo(Government::class);
    }

    public function createOrUpdateWorkingDays($workingDays) {
        // delete old
        DB::table('working_days')->where('branch_id', $this->id)->delete();

        // add new
        foreach ($workingDays as $item) {
            DB::table('working_days')->insert([
                "branch_id" => $this->id,
                "day" => $item,
            ]);
        }
    }
}
