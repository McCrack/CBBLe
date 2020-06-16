<?php


namespace App\Lab;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatchController extends \App\Http\Controllers\Controller
{
	/**
	 * @param Request $request
	 * @return Response
	 */
	public function __invoke(Request $request)
	{
		foreach ($request->all() as $modelName => $node) {
			foreach ($node as $id => $data) {
				$model = ModelFactory::make($modelName, $id);
				$model->patch($data);
			}
		}
		return response(null, 204);
	}
}
