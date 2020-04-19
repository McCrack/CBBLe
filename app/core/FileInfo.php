<?php

namespace App\core;

use Storage;
use SplFileInfo;

class FileInfo extends SplFileInfo
{

    private $uri;
    private $mime;
    private $type;

    public function __construct($path)
    {
        parent::__construct(storage_path("app/{$path}"));
        $this->path = $path;
        $this->uri = Storage::url($path);
        $this->mime = Storage::getMimeType($path);
        $this->type = $this->checkType();
    }

    public function __get($key)
    {
        return $this->{$key} ?? null;
    }
    public function checkType()
    {
        $type = $this->getType();
        if ($type == "file") {
            $mime = explode('/', $this->mime);
            if (in_array($mime[0], ['text', 'video', 'image'])) {
                $type = $mime[0];
            } else {
                $extension = $this->getExtension();
                $type = in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip'])
                    ? $extension
                    : "application";
            }
        }
        return $type;
    }
}
