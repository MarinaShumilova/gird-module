<?php

use App\Models\Complaint;
use Illuminate\Database\Seeder;

class ComplaintsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

      $complaintsList=[
              [
                  'start_at' => '21-10-12',
                  'vehicle'=>'Фургон',
                  'numb_order'=>'5647',
                  'warranty_type_id' => 1,
                  'reason_id' =>1,
                  'type_comp_id' => 1,
                  'contractor_id' => 1,
                  'culprit_id'=>1,
                  'executor_id'=>1,
                  'status_id' => 1,
                  'warranty_decree'=>1,
              ],
          [
              'start_at' => '21-03-06',
              'vehicle'=>'Кабина',
              'numb_order'=>'6654',
              'warranty_type_id' => 1,
              'reason_id' =>1,
              'type_comp_id' => 1,
              'contractor_id' => 2,
              'culprit_id'=>1,
              'executor_id'=>1,
              'status_id' => 2,
              'warranty_decree'=>1,
          ],
          [
              'start_at' => '21-08-09',
              'vehicle'=>'Надрамник',
              'numb_order'=>'5684',
              'warranty_type_id' => 1,
              'reason_id' =>1,
              'type_comp_id' => 1,
              'contractor_id' => 1,
              'culprit_id'=>1,
              'executor_id'=>1,
              'status_id' => 1,
              'warranty_decree'=>1,
          ]




      ];

        foreach ($complaintsList as $complaint) {
          Complaint::create($complaint);
        };










    }
}
