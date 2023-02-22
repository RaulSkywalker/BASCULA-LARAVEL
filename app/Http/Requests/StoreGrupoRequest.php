<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGrupoRequest extends FormRequest
{
// protected $redirectRoute = 'post.create';
//ruta que puedes definir en alguno de los archivos de la carpeta routes/
// por si falla la validación

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => ['required', Rule::unique('productos')->ignore(request()->oldname, "name")],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'El :attribute ya existe, pon otro nombre.',
            'name.required' => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre del producto',
        ];
    }

}

/**
 * Leer:
 * https://styde.net/como-trabajar-con-form-requests-en-laravel/
 * https://laravel.com/docs/9.x/validation
 */
