<?php

namespace Database\Seeders;

use App\Models\FollowupDealStage;
use App\Models\FollowupDrip;
use App\Models\FollowupSequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FollowUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // FollowupDealStage::truncate();
        // $faker = Faker::create();     // creating the object of class faker
        // $titles = [
        //     'COLD LEADS',
        //     'WARM LEADS',
        //     'ESTIMATED REQUESTED',
        //     'ESTIMATED SCHEDULED',
        //     'IN DRAFT',
        //     'PROPOSAL(S) SENT',
        //     'PROPOSAL(S) REJECTED',
        //     'Project Accepted',
        //     'PROJECT SCHEDULED',
        //     'PROJECT IN PROGRESS',
        //     'PROJECT COMPLETE',
        // ];

        // $dealStages = [];

        // foreach ($titles as $title) {
        //     $dealStages[] = [
        //         'deal_stage' => $title,
        //         'description' => $faker->sentence,
        //         'image_path' => null,
        //         'changes_by' => 49,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }

        // FollowupDealStage::insert($dealStages);

        // $dealStages = FollowupDealStage::get();

        // $sequences = [];

        // foreach ($dealStages as $stage) {
        //     $sequences[] = [
        //         'deal_stage_id' => $stage->id,
        //         'sequence_name' => $faker->sentence,
        //         'sort_order' => '1',
        //         'changes_by' => 49,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }

        // FollowupSequence::insert($sequences);

        // $sequences = FollowupSequence::get();
        
        // FollowupDrip::truncate();

        // $email_body = "
        //     Hello {{CLIENT_NAME}},

        //     Your request has been received! Thank you for considering us–-we'll be in touch soon.
            
        //     Please find a copy of your request below.
            
        //     If you have any questions regarding this request, please don't hesitate to get in touch with us at {{DEFAULT_EMAIL}}.
            
        //     Sincerely,
            
        //     {{COMPANY_NAME}}";

        // // Replace newline characters with \n
        // $email_body = str_replace(["\r\n", "\r", "\n"], '\n', $email_body);


        // $dripsData = [];
        // foreach ($sequences as $sequence) {
        //     $dripsData[] = [
        //         'sequence_id' => $sequence->id,  // Assuming $sequence is an array, not an Eloquent model
        //         'drip_name' => $faker->sentence,
        //         'send_time' => $faker->numberBetween(60, 240),  // Random number between 60 and 240
        //         'type' => $faker->randomElement(['SMS Message', 'Email', 'Both']),
        //         'email_subject' => $faker->sentence,
        //         'email_body' => $email_body,  // Assuming $email_body is defined somewhere
        //         'sms_msg' => $faker->sentence,
        //         'active' => true,
        //         'changes_by' => 49,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];

        //     $dripsData[] = [
        //         'sequence_id' => $sequence->id,  // Assuming $sequence is an array, not an Eloquent model
        //         'drip_name' => $faker->sentence,
        //         'send_time' => $faker->numberBetween(60, 240),  // Random number between 60 and 240
        //         'type' => $faker->randomElement(['SMS Message', 'Email', 'Both']),
        //         'email_subject' => $faker->sentence,
        //         'email_body' => $email_body,  // Assuming $email_body is defined somewhere
        //         'sms_msg' => $faker->sentence,
        //         'active' => true,
        //         'changes_by' => 49,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];

        //     $dripsData[] = [
        //         'sequence_id' => $sequence->id,  // Assuming $sequence is an array, not an Eloquent model
        //         'drip_name' => $faker->sentence,
        //         'send_time' => $faker->numberBetween(60, 240),  // Random number between 60 and 240
        //         'type' => $faker->randomElement(['SMS Message', 'Email', 'Both']),
        //         'email_subject' => $faker->sentence,
        //         'email_body' => $email_body,  // Assuming $email_body is defined somewhere
        //         'sms_msg' => $faker->sentence,
        //         'active' => true,
        //         'changes_by' => 49,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }

        
        // FollowupDrip::insert($dripsData);



        $emailContentHTML = "
            <p>Hi, {first-name}<br>My name is {salesperson-name} with {company-name}!<br><br>We just received your request for a quote, and would like to schedule a date & time to discuss your request in more detail!</p>

            <strong>To select a date & time,</strong> <strong>click the button below to visit our online scheduler:</strong>

            <p>{view-request-button}</p>

            <p>You may also reach us via phone: {company-phone}<br><br>We look forward to being of service!<br><br>Thank you for the opportunity,<br>{salesperson-name} with {company-name}</p>
        ";
        // dd($emailContentHTML);

        // dd( $emailContentHTML);
        // Fetch all records from the FollowupDrip table
        $followupDrips = FollowupDrip::all();

        // Loop through each record and update the 'email_body' field
        foreach ($followupDrips as $followupDrip) {
            $followupDrip->update(['email_body' =>  $emailContentHTML]);
            $followupDrip->save();
        }

        
    }
}
