<?php

namespace App\core;

use Str;
use Storage;

class FS
{
    public function __construct($path)
    {
    }

    /**
     * Get directory content
     *
     * @param  String  $request
     * @return Array
     */
    public static function getContent($path, $filter = null)
    {
        $content = [];
        foreach (Storage::directories($path) as $dir) {
            $content[] = new FileInfo($dir);
        }

        foreach (Storage::files($path) as $file) {
            $info = new FileInfo($file);
            if (empty($filter) || preg_match("/^{$filter}$/", $info->type)) {
                $content[] = $info;
            }
        }

        return $content;
    }
    public static function upload($path, $seek)
    {
        $raw_data = file_get_contents('php://input');

        if ($seek > 0) {
            //$size = Storage::append($path, $raw_data);
            $fullpath = storage_path("app/{$path}");
            $file = fopen($fullpath, "a");
            fwrite($file, $raw_data);
            fclose($file);
        } else {
            Storage::put($path, $raw_data);
        }
        return (Storage::size($path) / 1022) >> 0;
    }
    public static function createDirectory($path)
    {
        $result = 0;
        if (Storage::missing($path)) {
            $result = Storage::makeDirectory($path) ? 1 : 0;
        }
        return (bool) $result;
    }
    public static function delete($list)
    {
        $result = 1;
        foreach ($list as $file) {
            $path = storage_path("app/{$file}");
            if (is_dir($path)) {
                $result &= Storage::deleteDirectory($file) ? 1 : 0;
            } else {
                $result &= Storage::delete($file) ? 1 : 0;
            }
        }
        return (bool) $result;
    }
    public static function zip($path)
    {
        $fullPath = storage_path("app/{$path}");
        $zip = new \ZipArchive;
        $zip->open("{$fullPath}.zip", \ZipArchive::CREATE);

        $DirectoryToZip = function ($DirectoryToZip, $path, &$zipFile, $local) {
            $result = 1;
            foreach (Storage::files($path) as $fullPath) {
                $result &= $zipFile->addFile(
                    storage_path("app/{$fullPath}"),
                    $local . "/" . basename($fullPath)
                ) ? 1 : 0;
            }
            foreach (Storage::directories($path) as $fullPath) {
                $result &= $DirectoryToZip(
                    $DirectoryToZip,
                    $fullpath,
                    $zipFile,
                    "{$local}/{$file}"
                );
            }
            return $result;
        };
        $pathItems = explode("/", $path);
        $result = $DirectoryToZip(
            $DirectoryToZip,
            $path,
            $zip,
            array_pop($pathItems)
        );
        $zip->close();
        return (bool) $result;
    }
    public static function unzip($path)
    {
        $result = 0;
        $type = Storage::getMimeType($path);
        if ($type === "application/zip") {
            $fullpath = storage_path("app/{$path}");
            $zip = new \ZipArchive;
            if ($zip->open($fullpath)) {
                $pathItems = explode("/", $fullpath);
                $result = $zip->extractTo(
                    implode("/", array_slice($pathItems, 0, -1))
                );
                $zip->close();
            }
        }
        return (bool) $result;
    }

    public static function move($sources, $target)
    {
        $result = 1;
        foreach ($sources as $source) {
            $basename = basename($source);
            $result &= Storage::move($source, "{$target}/{$basename}") ? 1 : 0;
        }
        return $result;
    }
    public static function rename($source, $name)
    {
        $pathItems = explode('/', $source);
        $pathItems = array_slice($pathItems, 0, -1);
        $pathItems[] = $name;
        $path = implode('/', $pathItems);
        if (Storage::missing($path)) {
            return Storage::move($source, $path) ? 1 : 0;
        } else {
            return 0;
        }
    }
    public static function copy($sources, $target)
    {
        $result = 1;
        foreach ($sources as $source) {
            $basename = basename($source);
            $fullpath = storage_path("app/{$source}");
            if (is_file($fullpath)) {
                if (Storage::exists("{$target}/{$basename}")) {
                    Storage::delete("{$target}/{$basename}");
                }
                $result &= Storage::copy($source, "{$target}/{$basename}") ? 1 : 0;
            } elseif (is_dir($fullpath)) {
                if (Storage::exists("{$target}/{$basename}")) {
                    Storage::deleteDirectory("{$target}/{$basename}");
                }
                $result &= self::copyDirectory($source, "{$target}/{$basename}") ? 1 : 0;
            }
        }
        return $result;
    }
    public static function copyDirectory($source, $target)
    {
        self::createDirectory($target);
        $result = self::copy(
            Storage::files($source),
            $target
        );
        foreach (Storage::directories($source) as $dir) {
            $result &= self::copyDirectory($source, "{$target}/{$dir}");
        }
    }
    public static function download($path)
    {
        return Storage::download($path);
    }
}
