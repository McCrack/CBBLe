<?php

namespace App\CBBLe\Explorer;

use Str;
use JSON;
use File;
use Storage;
use AppConfig;
use App\core\FS;
use App\core\FileInfo;
use App\core\Dictionary;
use Illuminate\Http\Request;

class Explorer extends \App\Http\Controllers\Controller
{
    public static function checkAccess()
    {
        $config = AppConfig::getInstance();
        if ($config->missing('Explorer')) {
            $config->addConfig("Explorer", "../app/CBBLe/Explorer/config.json");
        }
        return in_array(\Auth::user()->role, $config->Explorer->access);
    }
    public static function index()
    {

        $explorer = function ($explorer, $root = "public", $level = 1) {
            $tree = [];
            foreach (Storage::directories($root) as $path) {
                $folder = basename($path);
                $tree[$folder] = ($level < 3)
                    ? $explorer($explorer, $path, $level + 1)
                    : null;
            }
            return count($tree) ? $tree : null;
        };
        return $explorer($explorer);
    }

    /**
     * Show pop-up, Get content and Download
     *
     * @param  Request $request
     * @param  Array $atgs
     * @return mixed
     */
    public function get(Request $request, $args)
    {
        return $this->{$args[0]}($request, $args);
    }
    /**
     * Show pop-up, Get content and Download
     *
     * @param  Request $request
     * @param  $atgs[1] - files check mode (checkbox or radio)
     * @param  $atgs[2] - Title of button (Add, Select or other)
     * @param  $atgs[3] - Files type filter
     * @return mixed
     */
    public function show(Request $request, $args)
    {
        $params = [
            'path'      => $request->path,
            'checkmode' => $args[1] ?? "checkbox"
        ];
        if (isset($args[3])) {
            $params['filter'] = $args[3];
        }

        $query = implode('&', array_map(function ($key, $value) {
            return "{$key}={$value}";
        }, array_keys($params), $params));

        $handle = time();
        return view('CBBLe.Explorer.pop-up', [
            'handle'    => "e-{$handle}",
            'caption'   => "Explorer",
            'query'     => $query,
            'button'    => $args[2] ?? false
        ]);
    }
    public function log(Request $request)
    {
        $handle = time();
        return view('CBBLe.Explorer.savelog', [
            'handle'    => "e-{$handle}",
            'caption'   => "Log"
        ]);
    }
    public function content(Request $request)
    {
        $pathSegments = explode('/', $request->path);
        $root = array_slice($pathSegments, 0, -1);

        return view('CBBLe.Explorer.content', [
            'hasOutDir' => (count($root) > 0),
            'current'   => $request->path,
            'root'      => implode('/', $root),
            'checkmode' => $request->checkmode,
            'content'   => FS::getContent($request->path, $request->filter ?? null)
        ]);
    }
    public function download(Request $request)
    {
        return FS::download($request->path);
    }

    /**
     * Copy, Move, Rename, Zip and UnZip
     *
     * @param  Request $request
     * @param  Array $args
     * @return String
     */
    public function patch(Request $request, $args)
    {
        return $this->{$args[0]}($request);
    }
    public function zip(Request $request)
    {
        return FS::zip($request->getContent())
            ? "Success"
            : "Error";
    }
    public function unzip(Request $request)
    {
        return FS::unzip($request->getContent())
            ? "Success"
            : "Error";
    }
    public function copy(Request $request)
    {
        return FS::copy($request->sources, $request->target)
            ? "Success"
            : "Error";
    }
    public function move(Request $request)
    {
        return FS::move($request->sources, $request->target)
            ? "Success"
            : "Error";
    }
    public function rename(Request $request)
    {
        return FS::rename(
            $request->source,
            $request->name
        ) ? "Success" : "Error";
    }

    /**
     * Upload files
     *
     * @param  Request  $request
     * @return String
     */
    public function put(Request $request, $args)
    {
        $info = pathinfo($request->file);
        $filename = Str::slug($info['filename']);
        $basename = "{$filename}.{$info['extension']}";
        $fullpath = "{$request->path}/{$basename}";
        $size = FS::upload($fullpath, (int) $request->seek);
        //? "Success"
        //: "Error";
        return sprintf("%s%'." . (64 - strlen($basename)) . "d KB", $basename, $size);
    }

    /**
     * Create Directory.
     *
     * @param  Request  $request
     * @return String
     */
    public static function post(Request $request, $args)
    {
        return FS::createDirectory($_GET['path'] . "/" . Str::slug($request->name))
            ? "Success"
            : "Error";
    }

    /**
     * Delete Files and Directories.
     *
     * @param  Request  $request
     * @return String
     */
    public function delete(Request $request, $args)
    {
        return FS::delete($request->all())
            ? "Success"
            : "Error";
    }
}
