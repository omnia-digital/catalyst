<?php

    namespace Modules\Livestream\Console\Commands;

    use Modules\Livestream\Omnia;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Storage;
    use Modules\Livestream\Episode;
    use Modules\Livestream\LivestreamAccount;
    use Modules\Livestream\PlaybackId;
    use Modules\Livestream\Repositories\VideoRepository;
    use Modules\Livestream\Services\EpisodeService;
    use Modules\Livestream\Services\MuxService;
    use Modules\Livestream\Video;
    use Modules\Livestream\VideoSourceType;

    class RestoreS3GlacierObjects extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'restore-s3-glacier-objects {--objectsFile=} {--set=} {--bucket=} {--prefix=} {--tier=} {--days=} {--profile=}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Migrate all Episodes to Mux from Wowza/S3';

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {
            if ($this->confirm("Are you sure you want to restor s3 glacier objects?")) {
                // Setup variables
                $bucket = $this->option('bucket');
                $file = $this->option('objectsFile');
                $prefix = $this->option('prefix'); // not used currently
                $tier = $this->option('tier');
                if (empty($tier)) {
                    $tier = 'Bulk';
                }
                $days = $this->option('days');
                if (empty($days)) {
                    $days = '30';
                }
                $profile = $this->option('profile');
                if (empty($profile)) {
                    $profile = 'default';
                }

                // Run command on each line of file, only reading one line at a time
                $handle = fopen($file, "r");
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        $command = '';
                        $command .= 'aws s3api restore-object --bucket ' . $bucket . ' ';
                        $command .= '--restore-request "Days='.$days.',GlacierJobParameters={Tier='.$tier.'}" ';
                        $line = substr($line, 0,strpos($line, ","));
                        $line = trim($line,'"+');
                        $this->info($line);
                        $command .= '--key "' . $line . '" ';
                        $command .= '--profile ' . $profile;
                        $this->info($command);
                        exec($command);
                    }

                    fclose($handle);
                } else {
                    $this->error('Could not open file');
                }

            } else {
                $this->info("Cancelled");
            }
        }
    }
