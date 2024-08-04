<?php

namespace App\Console\Commands;

use App\Models\Feedback;
use Illuminate\Console\Command;

class GetExternalFeedbacks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-external-feedbacks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get feedbacks from external source';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = "https://feedier-production.s3.eu-west-1.amazonaws.com/special/Reviews+Import.csv";

        //open csv file and read it
        $csv = fopen($url, 'r');

        $this->info('File opened successfully');

        // create an associative array
        $feedbacks = [];

        if ($csv !== false) {

            // read the firts line as headers for the keys
            $headers = fgetcsv($csv);

            // read the rest of the lines to store data in the feedbacks associative array
            while (($row = fgetcsv($csv)) !== false) {
                $feedbacks[] = array_combine($headers, $row);
            }
        } else {
            $this->error('File could not be opened');
        }

        fclose($csv);

        // save the feedbacks in the database
        foreach ($feedbacks as $feedback) {

            // Validate required data for the feedback

            if (!isset($feedback['Reviews Content']) || empty($feedback['Reviews Content'])) {
                $this->warn('Skipping feedback with empty message');
                continue;
            }


            // Check if the feedback already exists in the database
            if (Feedback::where('message', $feedback['Reviews Content'])->exists()) {

                $start = substr($feedback['Reviews Content'], 0, 10);
                $this->info('Feedback that starts with " ' . $start . ' " already exists');
                continue;
            } else {

                // save the feedback in the database

                Feedback::create(
                    [
                        'user_id' => null,
                        'email' => null,
                        'message' => $feedback['Reviews Content'],
                        'source' => 'EXTERNAL',
                        'source_name'=> $feedback['Source'],
                        'rating' => $feedback['Rating'],

                    ]
                );
            }
        }

        $this->info('External feedbacks saved successfully');
    }
}
