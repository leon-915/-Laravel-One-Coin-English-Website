<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AvailableTeachers;
use Auth;

class Loggedinteachers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if(!Auth::guest()) {
			$availableTeachers = AvailableTeachers::where('user_id', Auth::id())->first();
			if(!empty($availableTeachers) && $availableTeachers->user_id == Auth::id()) {
				$availableTeachers->updated_at = date('Y-m-d H:i:s');
				$availableTeachers->save();	
			} else {
				$data = [
					"user_id" => Auth::id(),
				];
				$availableTeachers = AvailableTeachers::create($data);
			}			
			
			$time_before_30_min = date('Y-m-d H:i:s', strtotime('-30 minute'));
			AvailableTeachers::whereRaw("updated_at < '$time_before_30_min'")->delete();
		}
        return $next($request);
    }
}
