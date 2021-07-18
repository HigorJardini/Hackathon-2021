<?php

namespace App\Http\Services\Api\Desktop\Export;

use App\Models\User;

use App\Services\Api\LogSystem;
use Illuminate\Support\Facades\Validator;
use App\Models\HistoricalStatus;

use App\Models\DenunciationFiles;
use App\Models\Denunciations;
use App\Models\Files;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

use ZipArchive;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class ExportFileService
{
    private $users;
    private $logSystem;
    private $denunciationFiles;
    private $denunciations;
    private $files;

    public function __construct(
                                    User $users,
                                    LogSystem $logSystem,
                                    DenunciationFiles $denunciationFiles,
                                    Denunciations $denunciations,
                                    Files $files
                               )
    {
        $this->users             = $users;
        $this->logSystem         = $logSystem;
        $this->denunciationFiles = $denunciationFiles;
        $this->denunciations     = $denunciations;
        $this->files             = $files;
    }

    public function export($denunciation_id)
    {
        

        try {

            $files = $this->denunciationFiles->select('files.*')
                                             ->where('denunciation_id', $denunciation_id)
                                             ->leftJoin('files', 'files.id', '=', 'denunciation_files.file_id')
                                             ->get();

            
            if(!empty($files)){
                return $this->zipImages($denunciation_id, $files);
            } else
                return [
                    'http_code' => 400,
                    'return'   => ['message' => 'Files not found']
                ];

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'ExportFileService/ExportFileService()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'ExportFileService register error']
            ]; 
        }
    }

    private function zipImages($id, $files)
    {
        try {
                    $files_list = $files;
                    $public_file_path = public_path('storage/denunciations/'. $id);
                    
                    foreach($files as $file)
                    {
                        $time_file = new Carbon;
                        $timer_file = $time_file::now()->format('his_dmY');
                        if(!file_exists($public_file_path))
                            mkdir($public_file_path);

                        $file_name = $public_file_path . '/imagem_' . $timer_file . '.' . $file->extension;
                        file_put_contents($file_name, base64_decode($file->file_content));

                    }
                
                    if(is_dir($public_file_path)){
                        $zip = new ZipArchive;
               
                        $time = new Carbon;
                        $time = $time::now()->format('his_dmY');
                        $fileName = "imagens_{$id}_{$time}.zip";
            
                        $public = public_path("storage/denunciations/$id/$fileName");
            
                        if ($zip->open($public, ZipArchive::CREATE) === TRUE)
                        {
                            $files = File::files(public_path("storage/denunciations/$id"));
                
                            foreach ($files as $file) {
                                $fileBase = basename($file);
                                $filePath = public_path("storage/denunciations/$id/$fileBase");
                                $zip->addFile($filePath, $fileBase);
                            }
                            
                            $zip->close();
                        }
                        
                        if (file_exists($public)) {

                            $this->deleteFiles($id, $files_list);

                            $header = [
                                'Content-Type: application/octet-stream',
                                'Content-Length: '. filesize($public)
                            ];
                            
                            return Response::download($public, $fileName, $header)->deleteFileAfterSend(true);
                        }
                    }
            

        } catch (\Throwable $th) {

            $this->logSystem->log_system_error(500, 'ExportFileService/ExportFileService()', $th);
            
            return [
                'http_code' => 500,
                'return'   => ['message' => 'ExportFileService register error']
            ]; 
        }
    }

    private function deleteFiles($denunciation_id, $files)
    {
        $this->denunciationFiles->where('denunciation_id', $denunciation_id)
                                ->delete();
        
        foreach($files as $file)
        {
            $this->files->where('id', $file->id)
                        ->update([
                            'file_content' => 'Deleted'
                        ]);
        }
    }


}
