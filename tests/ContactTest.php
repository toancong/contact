<?php

namespace Bean\Contact\Tests;

use Bean\Contact\Api\Contacts\Adapter;
use Bean\Contact\Tests\TestCase;
use Bean\Contact\Models\Contact;
use CloudCreativity\LaravelJsonApi\Encoder\Parameters\EncodingParameters;

class ContactTest extends TestCase
{
    public function testBrowseContact()
    {
        factory(Contact::class, 15)->create();
        $this->assertEquals(15, Contact::count());
    }

    public function testBrowseContactByAdapter()
    {
        factory(Contact::class, 15)->create();
        $adapter = app()->make(Adapter::class);
        $result = $adapter->query(new EncodingParameters);
        $this->assertEquals(15, count($result->getData()));
    }

    public function testSaveContact()
    {
        $user = new User;
        $user->id = rand();
        $contact = factory(Contact::class)->make([
            'object_type' => null,
            'object_id' => null,
            'name' => null,
        ])->toArray();
        $user->saveContact('contact', $contact);

        $this->assertEquals(1, Contact::count());
        $this->assertArraySubset(array_merge($contact, [
            'object_type' => get_class($user),
            'object_id' => $user->id,
            'name' => 'contact',
        ]), Contact::get()->first()->toArray());
    }

    public function testGetContact()
    {
        factory(Contact::class, 15)->create();
        $user = new User;
        $user->id = rand();

        $contact1 = factory(Contact::class)->make([
            'object_type' => null,
            'object_id' => null,
            'name' => null,
        ])->toArray();
        $user->saveContact('main', $contact1);

        $contactShipping = factory(Contact::class)->make([
            'object_type' => null,
            'object_id' => null,
            'name' => null,
        ])->toArray();
        $user->saveContact('shipping', $contactShipping);

        $contactBilling = factory(Contact::class)->make([
            'object_type' => null,
            'object_id' => null,
            'name' => null,
        ])->toArray();
        $user->saveContact('billing', $contactBilling);

        $contactMain = factory(Contact::class)->make([
            'object_type' => null,
            'object_id' => null,
            'name' => null,
        ])->toArray();
        $user->saveContact('main', $contactMain);

        $this->assertEquals(18, Contact::count());
        $this->assertEquals(3, Contact::where([
            'object_type' => get_class($user),
            'object_id' => $user->id,
        ])->count());
        $this->assertEquals(3, $user->contacts->count());
        $this->assertEquals(3, $user->contacts()->count());

        $this->assertArraySubset(array_merge($contactMain, [
            'object_type' => get_class($user),
            'object_id' => $user->id,
            'name' => 'main',
        ]), $user->contact('main')->toArray());

        $this->assertArraySubset(array_merge($contactBilling, [
            'object_type' => get_class($user),
            'object_id' => $user->id,
            'name' => 'billing',
        ]), $user->contact('billing')->toArray());

        $this->assertArraySubset(array_merge($contactShipping, [
            'object_type' => get_class($user),
            'object_id' => $user->id,
            'name' => 'shipping',
        ]), $user->contact('shipping')->toArray());


        $this->assertArraySubset(array_merge($contactMain, [
            'object_type' => get_class($user),
            'object_id' => $user->id,
            'name' => 'main',
        ]), $user->contact_main->toArray());

        $this->assertArraySubset(array_merge($contactBilling, [
            'object_type' => get_class($user),
            'object_id' => $user->id,
            'name' => 'billing',
        ]), $user->contact_billing->toArray());

        $this->assertArraySubset(array_merge($contactShipping, [
            'object_type' => get_class($user),
            'object_id' => $user->id,
            'name' => 'shipping',
        ]), $user->contact_shipping->toArray());
    }
}
