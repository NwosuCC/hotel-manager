<?php

namespace App\Http\Middleware\Custom;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;

class JsonMiddleware
{
  protected $factory;


  public function __construct(ResponseFactory $factory)
  {
    $this->factory = $factory;
  }

  /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $request->headers->set('Accept', 'application/json');

      // Get original response
      $response = $next($request);

      if(  $response instanceof JsonResponse){
        $response = $this->factory->json(
          $response->content(), $response->status(), $response->headers->all()
        );
      }

      return $response;
    }
}
