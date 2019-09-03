<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }


  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'room_id' => [
        'required', Rule::exists('rooms', 'id')
      ],
      'start_date' => [
        'required', 'after_or_equal:today'
      ],
      'end_date' => [
        'after:start_date'
      ],
      'customer_full_name' => [
        'required', 'string'
      ],
      'customer_email' => [
        'required', 'string', 'email', 'max:255',
      ],
    ];
  }


  /**
   * Called before the actual validation
   * Ensures the provided requirements.required_formats are supported
   */
  public function withValidator($validator)
  {
//    $validator->after(function ($validator) {
//
//    });
  }

}
