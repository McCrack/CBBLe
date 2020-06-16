<?php

namespace App\Lab;

use App\Lab\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
	/**
	 * @return JsonResponse
	 */
	public function frontend()
	{
		$model = ModelFactory::make('Settings', 'frontend');
		return response()->json($model->toArray());
	}

	/**
	 * @return JsonResponse
	 */
	public function lab()
	{
		$model = ModelFactory::make('Settings', 'lab');
		$model->roles = User::groupBy('role')->get(['role'])->pluck('role');
		$model->themes = array_map(function($path){
			return pathinfo($path)['filename'];
		}, Storage::disk('root')->files(public_path('lab/css/themes')));

		return response()->json($model->toArray());
	}

	/**
	 * @return JsonResponse
	 */
	public function personal()
	{
		$user = Auth::user();
		$roles = User::groupBy('role')->get(['role'])->pluck('role');
		$themes = array_map(function($path){
			return pathinfo($path)['filename'];
		}, Storage::disk('root')->files(public_path('lab/css/themes')));
		return response()->json([
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'languages' => config('lab.languages'),
			'language' => $user->config['language'] ?? config('lab.language'),
			'theme' => $user->config['theme'] ?? config('lab.theme'),
			'roles'	=> $roles,
			'themes' => $themes,
		]);
	}
}
