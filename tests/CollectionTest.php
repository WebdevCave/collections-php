<?php

namespace WebdevCave\Colections\Tests;

use WebdevCave\Collections\Collection;
use PHPUnit\Framework\TestCase;
use WebdevCave\Collections\LazyCollection;

class CollectionTest extends TestCase
{
    public function testGet()
    {
        $data = [
            'a' => [
                'b' => [
                    'c' => 123
                ]
            ]
        ];

        $collection = new Collection($data);

        // Test getting an existing value
        $this->assertEquals(123, $collection->get('a.b.c'));

        // Test getting a non-existent value
        $this->assertNull($collection->get('x.y.z'));
    }

    public function testHas()
    {
        $data = [
            'a' => [
                'b' => [
                    'c' => 123
                ]
            ]
        ];

        $collection = new Collection($data);

        // Test checking an existing key
        $this->assertTrue($collection->has('a.b.c'));

        // Test checking a non-existent key
        $this->assertFalse($collection->has('x.y.z'));
    }

    public function testSet()
    {
        $collection = new Collection();

        // Set a new value
        $collection->set('x.y.z', 456);

        // Check if the value was set correctly
        $this->assertEquals(456, $collection->get('x.y.z'));

        // Set a value on an existing key
        $collection->set('a.b.c', 789);

        // Check if the value was replaced correctly
        $this->assertEquals(789, $collection->get('a.b.c'));
    }

    public function testDelete()
    {
        // Arrange
        $data = [
            'user' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'address' => [
                    'city' => 'New York',
                    'country' => 'USA'
                ]
            ]
        ];

        $collection = new Collection($data);

        // Act
        $collection->delete('user.address.city');

        // Assert
        $this->assertNull($collection->get('user.address.city'));
        $this->assertTrue($collection->has('user.address.country'));
    }

    public function testCountable()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);

        // Check the count of elements
        $this->assertEquals(3, count($collection));

        // Add a new element
        $collection['d'] = 4;

        // Check the count after adding a new element
        $this->assertEquals(4, count($collection));
    }

    public function testIteratorAggregate()
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($data);

        // Check if iteration returns the expected elements
        foreach ($collection as $key => $value) {
            $this->assertEquals($data[$key], $value);
        }
    }

    public function testJsonSerializable()
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($data);

        // Check if JSON serialization returns the expected data
        $this->assertEquals(json_encode($data), json_encode($collection));
    }

    public function testClear()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);

        $this->assertFalse($collection->isEmpty());

        $collection->clear();

        $this->assertTrue($collection->isEmpty());
    }

    public function testCount()
    {
        $collection = new Collection([1,2,3]);
        $this->assertEquals(3, $collection->count());

        $collection->append(4);
        $this->assertEquals(4, $collection->count());

        $collection->delete(0);
        $this->assertEquals(3, $collection->count());

        $collection->clear();
        $this->assertEquals(0, $collection->count());
    }
}
