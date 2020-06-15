<?php


namespace App\Lab\Models;


use App\Lab\Models\Interfaces\PatchModelInterface;
use Exception;
use Illuminate\Support\Facades\Storage;

class Settings implements PatchModelInterface
{
	/**
	 * @var string
	 */
	private string $path;

	/**
	 * @var array
	 */
	private array $container = [];

	/**
	 * @param string $configFileName
	 * @return void
	 */
	public function load(string $configFileName): void
	{
		$path = $this->makePath($configFileName);
		if (Storage::disk('root')->exists($path)) {
			$this->container = include base_path($path);
		}
	}
	private function makePath($fileName)
	{
		$this->path = "config/{$fileName}.php";
		return $this->path;
	}
	/**
	 * @param string $key
	 * @return mixed|null
	 */
	public function __get(string $key)
	{
		return $this->container[$key] ?? null;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set(string $key, mixed $value): void
	{
		$this->container[$key] = $value;
	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function save(): bool
	{
		if (empty($this->path)) {
			throw new Exception("Undefined config file name");
		}
		$saved = Storage::disk('root')
			->put($this->path, '<?php return '. var_export($this->container, true) . ';');
		return (BOOL)$saved;
	}

	public function patch(array $data): void
	{
		$this->container = array_merge($this->container, $data);
		$this->save();
	}
}
