<?php

use App\Http\Controllers\Controller;

if (! function_exists('alertSupport')) {
  /**
   * Flashes unexpected error alert and (toDo: informs Support immediately - bugsnag)
   * @param   string $report
   * @param   bool   $alert
   * @return string
   */
  function alertSupport(string $report = null, bool $alert = true){
    $report = $report ?: 'Operation failed.';

    $error = "{$report} Support is on this unexpected error right away";

    if($alert){
      flash( $error, 'danger');
    }

    return $error;
  }
}

if (! function_exists('noAuthError')) {
  /**
   * Returns an 'unauthorised' error
   */
  function noAuthError()
  {
    return response()->json([
      'message' => "You are not authorised to update this entry"
    ], 403);
  }
}

if (! function_exists('flash')) {
  /**
   * Flashes a JSON String message to the session, optionally indicating the alert type
   * @param   string  $message The message to display
   * @param   string  $type The alert type. One of [success, danger, info]
   *
   * E.g flash('Post not found', 'danger')
   */
  function flash($message, $type = 'success')
  {
    session()->flash('message', json_encode( compact('message', 'type')));
  }
}

if (! function_exists('qs')) {
  /**
   * Wrapper to enforce type-hinting for local query scopes (qs => query scopes)
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @return  \Illuminate\Database\Eloquent\Builder
   */
  function qs($query)
  {
    return $query;
  }
}

if (! function_exists('trusted')) {
  /**
   * Relaxes the guards just for this one operation
   * @param \App\Models\Model | \Illuminate\Auth\Authenticatable $model
   * @param Closure $callback
   * @return  void
   */
  function trusted($model, $callback)
  {
    $model->__callStatic('unguard', []);

    call_user_func($callback);

    $model->__callStatic('reguard', []);
  }
}
