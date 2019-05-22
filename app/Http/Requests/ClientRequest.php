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
            'document_type' => 'required|in:' . implode(',', array_keys(__('app.selects.person.document_type'))),
            'document' => 'required|numeric|digits_between:6,12|unique:clients,document,' . $this->id,
            'name' => 'required|min:3|max:50|alpha_space',
            'last_name' => 'required|min:3|max:50|alpha_space',
            'sex' => 'required|in:' . implode(',', array_keys(__('app.selects.person.sex'))),
            'civil_status' => 'required|in:' . implode(',', array_keys(__('app.selects.person.civil_status'))),
            'birth_date' => 'required|date|before:Today',
            'address' => 'required|min:3|max:50',
            'neighborhood' => 'required|min:3|max:50',
            'phone' => 'required_without:cellphone|nullable|numeric|digits_between:6,12|bail',
            'cellphone' => 'nullable|numeric|digits_between:6,12|bail',
            'rfid' => 'nullable|numeric|digits_between:4,12|unique:clients,rfid,' . $this->id . '|bail',
            'end' => 'required|date',
        ];
    }
}
