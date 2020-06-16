<?php


namespace App\Lab\Models;


use App\Lab\Models\Interfaces\PatchModelInterface;
use Exception;
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
	private array $rules = [
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
	];
	/**
	 * @var array
	 */
	private array $container = [];

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return $this->container;
	}

	/**
	 * @param string $configFileName
	 * @return void
	 */
	public function load(string $configFileName): void
	{
		$this->path = config_path("{$configFileName}.php");
		if (file_exists($this->path)) {
			$this->container = include $this->path;
		}
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
	 * @param $value
	 */
	public function __set(string $key, $value): void
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
		$saved = file_put_contents(
			$this->path,
			"<?php\n\nreturn ". var_export($this->container, true) . ";\n"
		);
		return (BOOL)$saved;
	}

	/**
	 * @param array $data
	 * @throws Exception
	 */
	public function patch(array $data): void
	{
		$validator = Validator::make($data, $this->rules);

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
