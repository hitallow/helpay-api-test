<?php

namespace App\Services\GoogleDrive;


use \Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
  private FileSystem $googleDisk;

  function __construct()
  {
    $this->googleDisk = Storage::disk('google');
  }

  /**
   * Envia um arquivo qualquer para o google drive
   *
   * @return bol true caso as informações tenham sido salvas com sucesso
   */
  public function sendFile($file, string $name)
  {
    return $this->googleDisk->put($name, $file);
  }
}
