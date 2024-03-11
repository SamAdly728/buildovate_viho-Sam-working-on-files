<?php

namespace App\Services;

use Illuminate\Support\Arr;

class ReportsManager
{
    public function leads_list() {
        
        try {
            $sql = "SELECT c.cust_id, c.company_id, CONCAT(c.first_name,' ', c.last_name)AS name, c.email, l.lead_id, l.opportunity_title, l.cost_of_lead, l.status, p.company_name
            FROM customers c
            JOIN leads l ON l.cust_id = c.cust_id
            LEFT JOIN companies p ON p.company_id = c.company_id
            ORDER BY c.first_name, c.last_name ASC;";
            $records = \DB::connection()->select($sql);
            return $records;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function specialty_categories() {
        try {
            $data = [];
            $records =  \App\Models\SpecialtyCategory::where('is_active', 1)->orderBy('name', 'ASC')->get();
            foreach($records as $record) {
                $sub_categories = [];
                $subs = \App\Models\SpecialtySubCategory::where('link_specialty_category_id', $record->id)->where('is_active', 1)->get();
                foreach($subs as $sub) {
                    $specialties =[];
                    $skills = \App\Models\Specialty::where('link_specialty_category_id', $record->id)->where('link_specialty_sub_category_id', $sub->id)->where('is_active', 1)->get();
                    foreach($skills as $skill) {
                        $specialties[]=array(
                            'id' => $skill->id,
                            'name' => $skill->name
                        );
                    }
                    $sub_categories[] =array(
                        'id' => $sub->id,
                        'name' => $sub->name,
                        'specialties' => $specialties
                    );
                }
                $data[] = array(
                    'id' => $record->id,
                    'name' => $record->name,
                    'sub_categories' => $sub_categories
                );
                // $record->sub_categories = $record->sub_categories;
                // foreach($record->sub_categories as $sub) {
                //     $sub->specialties;
                // }
                // $data[] = $record;
            }
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function specialty_category($id) {
        try {
            
            $record =  \App\Models\SpecialtyCategory::find($id);
            $record->sub_categories = $record->sub_categories;
            foreach($record->sub_categories as $sub) {
                $sub->specialties;
            }
            

            return $record;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}