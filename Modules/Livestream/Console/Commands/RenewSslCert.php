<?php

namespace Modules\Livestream\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class CheckNewSslCert
 * Check directories in Cert Dir and get last modified dates. If any have been modified within the last minute,
 * get the cert, convert to needed format, then copy over to needed servers and put in the correct place.
 */
class RenewSslCert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew-ssl-cert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the script to renew SSL cert and copy to  server';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('[START] - Renew SSL Cert');

        try {
            $local_server_storage = Storage::disk('local_server_root');
            $local_cert_dir_path = env('LOCAL_SSL_CERT_DIR');
            $localCertDirectoryName = '139784';
            $localCertName = 'server.crt';

            Log::info('Starting LetsEncrypt Cert Renew process');

//            $output = shell_exec('/bin/bash /home/forge/.letsencrypt-renew/' . $localCertDirectoryName .' > /home/forge/.letsencrypt-renew/' . $localCertDirectoryName . '.out');

            Log::info('Finished LetsEncrypt Cert Renew Process');

            $newCertFilePath = $local_server_storage->get($local_cert_dir_path . '/' . $localCertDirectoryName . '/' . $localCertName);

//            $files = $local_server_root->files($local_cert_dir_path);

            // copy to Wowza server
            Log::info('Copy new certificate to Wowza server');
            if (!empty($newCertFilePath)) {
                $wowza_cert_dir_path = env('WOWZA_SSL_CERT_DIR');
                $certFileName = 'omnia-cert-' . date('Ymd-hms') . '.crt';
                $wowza = Storage::disk('wowza');
                $wowza->putFileAs($wowza_cert_dir_path, new File($newCertFilePath), $certFileName);
            }
            Log::info('Import new certificate into Wowza JDK store');

            $this->execute('livestream-wowza')->run(
                'sudo keytool -delete -alias omnia-app-org -keystore /usr/local/WowzaStreamingEngine-4.5.0/jre1.8.0_77/lib/security/cacerts',
                'sudo keytool -import -file $WOWZACERTPATH -alias omnia-app-org -keystore /usr/local/WowzaStreamingEngine-4.5.0/jre1.8.0_77/lib/security/cacerts'
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        Log::info('[FINISHED] - Renew SSL Cert');
    }
}
