<?php


namespace App\Lab\Models;


use App\Lab\Models\Interfaces\PatchModelInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

	/**
	 * @param array $data
	 * @throws Exception
	 */
	public function patch(array $data): void
	{
		$validator = Validator::make($data, [
			'site_name' => 'string|max:64',
			'email' => 'email|string|max:64',
			'language' => 'alpha|size:2',
			'locations' => 'alpha|size:2',
			'theme' => 'string|max:16',
			'currency_rates' => 'array',
			'phones' => 'array',
			'languages' => 'array',
			'access' => 'array',
			'privileges' => 'array',
		]);

		$p = function ($p, $data, &$container) {
			foreach ($data as $key => $value) {
				if (is_array($value) && array_diff_key($value, array_keys(array_keys($value)))) {
					$p($p, $value, $container[$key]);
				} else {
					$container[$key] = $value;
				}
			}
		};
		$p($p, $validator->valid(), $this->container);

		$this->save();
		$validator->validate();
	}

}
