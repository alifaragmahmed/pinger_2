<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\BranchLevel;
use App\Models\EntuityStatus;
use App\Models\Government;
use App\Models\LineCapacitie;
use App\Models\LineType;
use App\Models\Network;
use App\Models\Project;
use App\Models\Router;
use App\Models\SwitchModel;
use App\Models\UpsInstallation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BranchesImport implements ToModel, WithHeadingRow
{

    protected function trim($name)
    {
        $name = str_replace("  ", " ", $name);
        //$name = strtolower($name);
        return $name;
    }

    protected function createOrUpdateNetwork($name)
    {
        $name = $this->trim($name);
        $network = Network::where('name', 'like', '%' . $name . '%')->first();

        if (!$network) {
            $network =  Network::create(
                ['name' => $name]
            );
        }

        return $network;
    }

    protected function createOrUpdateProject($name)
    {
        $name = $this->trim($name);
        $project = Project::where('name', 'like', '%' . $name . '%')->first();

        if (!$project) {
            $project =  Project::create(
                ['name' => $name]
            );
        }

        return $project;
    }

    public function createOrUpdateBranchLevel($name)
    {
        $name = $this->trim($name);
        $level = BranchLevel::where('name', 'like', '%' . $name . '%')->first();

        if (!$level) {
            $level = BranchLevel::create(
                ['name' => $name]
            );
        }

        return $level;
    }

    public function createOrUpdateLineType($name)
    {
        $name = $this->trim($name);
        $lineType = LineType::where('name', 'like', '%' . $name . '%')->first();

        if (!$lineType) {
            $lineType = LineType::create(
                ['name' => $name]
            );
        }

        return $lineType;
    }

    public function createOrUpdateLineCapacity($name)
    {
        $name = $this->trim($name);
        $lineCap = LineCapacitie::where('name', 'like', '%' . $name . '%')->first();

        if (!$lineCap) {
            $lineCap= LineCapacitie::create(
                ['name' => $name]
            );
        }

        return $lineCap;
    }

    public function createOrUpdateEntuityStatus($name)
    {
        $name = $this->trim($name);
        $entuityStatus = EntuityStatus::where('name', 'like', '%' . $name . '%')->first();

        if (!$entuityStatus) {
            $entuityStatus= EntuityStatus::create(
                ['name' => $name]
            );
        }

        return $entuityStatus;
    }

    public function createOrUpdateRouter($name)
    {
        $name = $this->trim($name);
        $router = Router::where('name', 'like', '%' . $name . '%')->first();

        if (!$router) {
            Router::create(
                ['name' => $name]
            );
        }

        return $router;
    }

    public function createOrUpdateSwitchModel($name)
    {
        $name = $this->trim($name);
        $switch = SwitchModel::where('name', 'like', '%' . $name . '%')->first();

        if (!$switch) {
            SwitchModel::create(
                ['name' => $name]
            );
        }

        return $switch;
    }

    public function createOrUpdateRouter_($name, $number)
    {
        $name = $this->trim($name);
        $router = Router::where('name', 'like', '%' . $name . '%')->first();

        if (!$router) {
            Router::create(
                ['name' => $name],
                ['number' => $number]
            );
        }

        return $router;
    }

    public function createOrUpdateUps($name)
    {
        $name = $this->trim($name);
        $ups = UpsInstallation::where('name', 'like', '%' . $name . '%')->first();

        if (!$ups) {
          $ups=  UpsInstallation::create(
                ['name' => $name]
            );
        }

        return $ups;
    }
    // public function createOrUpdateUGovernment($name)
    // {
    //     $name = $this->trim($name);
    //     $government = Government::where('name', 'like', '%' . $name . '%')->first();

    //     if (!$government) {
    //       $government=  Government::create(
    //             ['name' => $name]
    //         );
    //     }

    //     return $government;
    // }

    protected function getWorkDays($data)
    {
        return explode(",", $data);
    }

    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        //dd($row['start_time']);
        //$startTime = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['start_time']));
        //dd($startTime);
        $startTime = date("H:i:s", strtotime($row['start_time']));
        $endTime = date("H:i:s", strtotime($row['end_time']));
        try {
            $data = [
                "name" => $row['name'],
                "area" => $row['area'],
                "sector" => $row['sector'],
                "financial_code" => $row['financial_code'],
                "post_number" => $row['post_number'],
                "technical_support_phone" => $row['technical_support_phone'],
                "technical_support_name" => $row['technical_support_name'],
                "branch_manager_phone" => $row['branch_manager_phone'],
                "branch_manager_name" => $row['branch_manager_name'],
                "telephone" => $row['telephone'],
                "viop_no" => $row['viop_no'],
                "branch_level_id" => optional($this->createOrUpdateBranchLevel($row['branch_level_id']))->id,
                //"working_days" => $this->getWorkDays($row['working_days']),
                "start_time" => $startTime,
                "end_time" => $endTime,
                "address" => $row['address'],
                "main_order_id" => $row['main_order_id'],
                "backup_order_id" => $row['backup_order_id'],
                "project_id" => optional($this->createOrUpdateProject($row['project_id']))->id,
                "modeling" => $row['modeling'],
                "ups_installation_id" => optional($this->createOrUpdateUps($row['ups_installation_id']))->id,
                "network_id" => optional($this->createOrUpdateNetwork($row['network_id']))->id,
                "line_type_id" => optional($this->createOrUpdateLineType($row['line_type_id']))->id,
                "line_capacity_id" => optional($this->createOrUpdateLineCapacity($row['line_capacity_id']))->id,
                "entuity_status_id" => optional($this->createOrUpdateEntuityStatus($row['entuity_status_id']))->id,
                "router_model_id" => optional($this->createOrUpdateRouter($row['router_model_id']))->id,
                "switch_model_id" => optional($this->createOrUpdateSwitchModel($row['switch_model_id']))->id,
                // "government_id" => optional($this->createOrUpdateUGovernment($row['government_id']))->id,
                "added_on_entuity" => $row['added_on_entuity'] == "Yes"? true : false,
                "lan_ip" => $row['lan_ip'],
                "additional_ips" => $row['additional_ips'],
                "ip_notes" => $row['ip_notes'],
                "notes" => $row['notes'],
                "wan_ip" => $row['wan_ip'],
                "tunnel_ip" => $row['tunnel_ip'],
                "router_serial" => $row['router_serial'],
                "entuity_systemname" => $row['entuity_systemname'],
                "switch_serial" => $row['switch_serial'],
                "switch_ip" => $row['switch_ip'],
                "switch_nots" => $row['switch_nots'],
                "atm_exists" => $row['atm_exists'] == "Yes" ? true : false,
                "atm_ip" => $row['atm_ip'],
                "installation_and_commissioning" => $row['installation_and_commissioning'] == "Yes"? true : false,
                "user_id" => auth()->user()->id,
            ];

            $resource = Branch::create($data);
            $resource = $resource->fresh();
            $resource->createOrUpdateWorkingDays($this->getWorkDays($row['working_days']));

            return $resource;
        } catch (Exception $th) {
            return null;
        }
    }
}
