<?php

namespace App\Http\Requests;

/**
 * @property mixed id
 */
class ClientRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50|alpha_space',
            'rfid' => 'nullable|numeric|digits_between:4,12|unique:clients,rfid,' . $this->id . '|bail',
            'end' => 'required|date',
        ];
    }
}
