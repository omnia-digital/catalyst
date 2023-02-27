<?php

namespace App\Console\Commands;

use App\Omnia;
use Illuminate\Console\Command;
use App\LivestreamAccount;
use App\Repositories\StreamRepository;
use App\Services\MuxService;

class DeleteAllAssetsForMuxLivestream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-all-assets-mux-livestream {--id=} {--errors}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will Only Delete 100 at a time';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->option('id');
        $errors = $this->option('errors');

        $muxService = new MuxService();
        $assets = $muxService->listAssets();

        dd($assets);

    }
}
