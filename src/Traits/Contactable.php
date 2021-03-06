<?php

namespace Bean\Contact\Traits;
use Bean\Contact\Models\Contact;

trait Contactable
{
    public function contacts()
    {
        return $this->hasMany($this->getContactModel(), 'object_id', 'id')->where('object_type', $this->getObjectName());
    }

    public function __get($name)
    {
        if (strpos($name, 'contact_') === 0) {
            return $this->contact(substr($name, 8));
        }
        return parent::__get($name);
    }

    public function contact($name)
    {
        return $this->getContactModel()::where([
            'object_type' => $this->getObjectName(),
            'object_id' => $this->getKey(),
            'name' => $name,
        ])->first();
    }

    public function saveContact($name, $contactData)
    {
        $key = [
            'object_type' => $this->getObjectName(),
            'object_id' => $this->getKey(),
            'name' => $name,
        ];
        $contactData = array_merge($contactData, $key);
        return $this->getContactModel()::updateOrCreate($key, $contactData);
    }

    public function getObjectName() {
        return get_called_class();
    }

    public function getContactModel()
    {
        return Contact::class;
    }
}
