<?php

namespace App\Lab\Models\Interfaces;

interface PatchModelInterface
{
	/**
	 * @param array $data
	 */
	public function patch(array $data): void;
}
